<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\StockModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory; // Add this use statement
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = (object) [
            'title' => 'Stock List',
            'list' => ['Home', 'Stock'],
        ];

        $page = (object) [
            'title' => 'list of stocks registered in the system',
        ];

        $activeMenu = 'stock';

        return view('stock.index', compact('breadcrumbs', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $stocks = StockModel::select('id_stock', 'date_stock', 'stock_quantity', 'id_product', 'id_user')
            ->with('product')
            ->with('user');

        return DataTables::of($stocks)
            ->addIndexColumn()
            ->addColumn('action', function ($stock) {
                $btn = '<button onclick="modalAction(\'' . url('/stock/' . $stock->id_stock . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stock/' . $stock->id_stock . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stock/' . $stock->id_stock . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = (object) [
            'title' => 'Add Stock',
            'list' => ['Home', 'Stock', 'Add'],
        ];

        $page = (object) [
            'title' => 'Add New Stock',
        ];

        $product = ProductModel::all();
        $user = UserModel::all();
        $activeMenu = 'stock';

        return view('stock.create', compact('breadcrumbs', 'page', 'activeMenu', 'product', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_stock' => 'required|date',
            'date_time_stock' => 'required',
            'stock_quantity' => 'required|integer',
            'id_product' => 'required|integer',
            'id_user' => 'required|integer',
        ]);

        if (StockModel::where('id_product', $request->id_product)->exists()) {
            $stock = StockModel::where('id_product', $request->id_product)->first();

            try {
                $stock->update([
                    'id_user' => $request->id_user,
                    'date_stock' => $request->date_time_stock, // Use the combined date+time
                    'stock_quantity' => $stock->stock_quantity + $request->stock_quantity,
                ]);
            } catch (\Throwable $th) {
                return redirect('/stock')->with('error','Stock has been failed to add');
            }
        } else {
            // Create a new request with the date_time_stock value
            $data = $request->all();
            $data['date_stock'] = $request->date_time_stock;
            StockModel::create($data);
        }

        return redirect('/stock')->with('success','Stock has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(StockModel $stock)
    {
        $breadcrumbs = (object) [
            'title' => 'Stock Detail',
            'list' => ['Home', 'Stock', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Stock Detail',
        ];

        $stock->load(['product', 'user']);

        $activeMenu ='stock';

        return view('stock.show', compact('breadcrumbs', 'page', 'activeMenu', 'stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockModel $stock)
    {
        $breadcrumbs = (object) [
            'title' => 'Edit Stock',
            'list' => ['Home', 'Stock', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Stock Data',
        ];

        $product = ProductModel::all();
        $user = UserModel::all();
        $activeMenu = 'stock';

        return view('stock.edit', compact('breadcrumbs', 'page', 'activeMenu', 'stock', 'product', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockModel $stock)
    {
        $request->validate([
            'date_stock' => 'required|date',
            'date_time_stock' => 'required',
            'stock_quantity' => 'required|integer',
            'id_product' => 'required|integer',
            'id_user' => 'required|integer',
        ]);

        try {
            $stock->update([
                'id_product' => $request->id_product,
                'id_user' => $request->id_user,
                'date_stock' => $request->date_time_stock,
                'stock_quantity' => $request->stock_quantity,
            ]);
            return redirect('/stock')->with('success', 'Stock has been updated');
        } catch (\Throwable $th) {
            return redirect('/stock')->with('error', 'Stock has failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockModel $stock)
    {
        $stock->delete();
        return redirect('/stock')->with('success','Stock has been deleted');
    }

    public function create_ajax()
    {
        $product = ProductModel::all();
        $user = UserModel::all();
        return view('stock.create_ajax', compact('product', 'user'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'date_stock' => 'required|date',
                'date_time_stock' => 'required',
                'stock_quantity' => 'required|integer',
                'id_product' => 'required|integer',
                'id_user' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                if (StockModel::where('id_product', $request->id_product)->exists()) {
                    $stock = StockModel::where('id_product', $request->id_product)->first();
                    $stock->update([
                        'id_user' => $request->id_user,
                        'date_stock' => $request->date_time_stock,
                        'stock_quantity' => $stock->stock_quantity + $request->stock_quantity,
                    ]);
                } else {
                    $data = $request->all();
                    $data['date_stock'] = $request->date_time_stock;
                    StockModel::create($data);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Stock created successfully',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create stock'
                ]);
            }
        }
        return redirect('/');
    }

    public function show_ajax(StockModel $stock)
    {
        $stock->load(['product', 'user']);
        return view('stock.show_ajax', compact('stock'));
    }

    public function edit_ajax(StockModel $stock)
    {
        $product = ProductModel::all();
        $user = UserModel::all();
        return view('stock.edit_ajax', compact('stock', 'product', 'user'));
    }

    public function update_ajax(Request $request, StockModel $stock)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validator = Validator::make($request->all(), [
                'date_stock' => 'required|date',
                'date_time_stock' => 'required',
                'stock_quantity' => 'required|integer',
                'id_product' => 'required|integer',
                'id_user' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $stock->update([
                    'id_product' => $request->id_product,
                    'id_user' => $request->id_user,
                    'date_stock' => $request->date_time_stock,
                    'stock_quantity' => $request->stock_quantity,
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Stock updated successfully',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to update stock'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(StockModel $stock)
    {
        $stock->load(['product', 'user']);
        return view('stock.confirm_ajax', compact('stock'));
    }

    public function delete_ajax(Request $request, StockModel $stock)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $stock->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Stock deleted successfully',
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to delete stock'
                ]);
            }
        }

    }

    public function import_ajax() {
        return view('stock.import');
    }

    public function store_import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if (!$request->hasFile('file_stock')) { // Changed from file_item
                return response()->json([
                    'status' => false,
                    'message' => 'No file uploaded',
                    'msgField' => ['file_stock' => ['Please select a file']] // Changed from file_item
                ]);
            }

            $rules = [
                'file_stock' => ['required', 'mimes:xlsx,xls', 'max:1024'] // Changed from file_item
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Failed',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $file = $request->file('file_stock'); // Changed from file_item
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);

                $insert = [];
                $update = [];
                if (count($data) > 1) {
                    foreach ($data as $row => $value) {
                        if ($row > 1) {
                            // Assuming Excel columns: A=id_product, B=id_user, C=date_stock (YYYY-MM-DD HH:MM:SS), D=stock_quantity
                            $id_product = $value['A'];
                            $id_user = $value['B'];
                            $date_stock = $value['C'];
                            $stock_quantity = $value['D'];

                            // Validate data types if necessary
                            if (!is_numeric($id_product) || !is_numeric($id_user) || !is_numeric($stock_quantity)) {
                                // Skip row or return error
                                continue;
                            }

                            // Check if stock for this product already exists
                            $existingStock = StockModel::where('id_product', $id_product)->first();

                            if ($existingStock) {
                                // Prepare for update (add to existing quantity)
                                $update[] = [
                                    'id_stock' => $existingStock->id_stock,
                                    'id_user' => $id_user,
                                    'date_stock' => $date_stock,
                                    'stock_quantity' => $existingStock->stock_quantity + $stock_quantity,
                                    'updated_at' => now()
                                ];
                            } else {
                                // Prepare for insert
                                $insert[] = [
                                    'id_product' => $id_product,
                                    'id_user' => $id_user,
                                    'date_stock' => $date_stock,
                                    'stock_quantity' => $stock_quantity,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ];
                            }
                        }
                    }

                    $importedCount = 0;
                    if (count($insert) > 0) {
                        StockModel::insert($insert); // Use insert for new records
                        $importedCount += count($insert);
                    }
                    if (count($update) > 0) {
                        foreach ($update as $stockData) {
                            StockModel::where('id_stock', $stockData['id_stock'])->update([
                                'id_user' => $stockData['id_user'],
                                'date_stock' => $stockData['date_stock'],
                                'stock_quantity' => $stockData['stock_quantity'],
                                'updated_at' => $stockData['updated_at']
                            ]);
                        }
                        $importedCount += count($update);
                    }


                    if ($importedCount > 0) {
                        return response()->json([
                            'status' => true,
                            'message' => $importedCount . ' rows imported/updated successfully'
                        ]);
                    }
                }

                return response()->json([
                    'status' => false,
                    'message' => 'No data imported. Check file format and content.'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Import failed: ' . $e->getMessage(),
                    'debug' => [
                        'file' => $e->getFile(),
                        'line' => $e->getLine()
                    ]
                ]);
            }
        }
        return redirect('/');
    }
}
