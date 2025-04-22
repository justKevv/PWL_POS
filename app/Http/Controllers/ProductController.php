<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Barryvdh\DomPDF\Facade\Pdf as Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = (object) [
            'title' => 'Product List',
            'list' => ['Home', 'Product'],
        ];

        $page = (object) [
            'title' => 'list of products registered in the system',
        ];

        $category = CategoryModel::all();

        $activeMenu = 'item';

        return view('product.index', compact('category', 'breadcrumbs', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $products = ProductModel::select('id_product', 'product_code', 'product_name', 'purchase_price', 'selling_price', 'id_category')
            ->with('category');

        if ($request->id_category) {
            $products = $products->where('id_category', $request->id_category);
        }

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('action', function ($product) {
                $btn = '<button onclick="modalAction(\'' . url('/item/' . $product->id_product . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/item/' . $product->id_product . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/item/' . $product->id_product . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getNextId(CategoryModel $category) {
        $lastProduct = ProductModel::where('id_category', $category->id_category)->orderBy('product_code', 'desc')->first();

        $nextId = $lastProduct ? ($lastProduct->id_product + 1) : 1;

        return response()->json([
            'next_id' => $nextId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = (object) [
            'title' => 'Add Product',
            'list' => ['Home', 'Item', 'Add'],
        ];

        $page = (object) [
            'title' => 'Add New Product',
        ];

        $category = CategoryModel::all();
        $activeMenu = 'item';

        return view('product.create', compact('category', 'breadcrumbs', 'page', 'activeMenu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|string|max:100',  // name must be filled, string type, and maximum 100 characters
            'product_name' => 'required|string|min:3|unique:m_product,product_name',  // password must be filled and minimum 3 characters
            'purchase_price' => 'required|integer',
            'selling_price' => 'required|integer',
            'id_category' => 'required:integer'
        ]);

        ProductModel::create($request->all());

        return redirect('/item')->with('success','Product has been added');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductModel $product)
    {
        $breadcrumbs = (object) [
            'title' => 'Product Detail',
            'list' => ['Home', 'Product', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Product Detail',
        ];

        $product->load('category');

        $activeMenu = 'item';

        return view('product.show', compact('product','breadcrumbs','page','activeMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductModel $product)
    {
        $category = CategoryModel::all();

        $breadcrumbs = (object) [
            'title' => 'Edit Product',
            'list' => ['Home', 'Product', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Product',
        ];

        $product->load('category');

        $activeMenu = 'item';

        return view('product.edit', compact('breadcrumbs', 'page', 'product', 'category', 'activeMenu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductModel $product)
    {
        $request->validate([
            'product_code' => 'required|string|max:100',
            'product_name' => 'required|string|min:3|unique:m_product,product_name,' . $product->id_product . ',id_product',
            'purchase_price' => 'required|integer',
            'selling_price' => 'required|integer',
            'id_category' => 'required:integer'
        ]);

        try {
            $product->update([
                'product_code' => $request->product_code,
                'product_name' => $request->product_name,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
                'id_category' => $request->id_category,
            ]);
            return redirect('/item')->with('success', 'Product has been updated');
        } catch (\Throwable $th) {
            return redirect('/item')->with('error', 'Product has failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductModel $product)
    {
        $product->delete();
        return redirect('/item')->with('success','Product has been deleted');
    }

    public function create_ajax()
    {
        $category = CategoryModel::all();
        return view('product.create_ajax', compact('category'));
    }

    public function show_ajax(ProductModel $product)
    {
        return view('product.show_ajax', compact('product'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_category' => 'required',
                'product_code' => 'required|unique:m_product,product_code',
                'product_name' => 'required|string|max:255',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            ProductModel::create($request->all());

            return response()->json([
               'status' => true,
               'message' => 'Product created successfully',
            ]);
        }

        return redirect('/');
    }

    public function edit_ajax(ProductModel $product)
    {
        $category = CategoryModel::all();
        return view('product.edit_ajax', compact('product', 'category'));
    }

    public function update_ajax(Request $request, ProductModel $product)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_category' => 'required',
                'product_code' => 'required|unique:m_product,product_code,' . $product->id_product . ',id_product',
                'product_name' => 'required|string|max:255',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            if ($product) {
                $product->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Product updated successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found',
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(ProductModel $product)
    {
        return view('product.confirm_ajax', compact('product'));
    }

    public function delete_ajax(Request $request, ProductModel $product)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if ($product) {
                $product->delete();
                return response()->json([
                   'status' => true,
                   'message' => 'Product deleted successfully',
                ]);
            } else {
                return response()->json([
                   'status' => false,
                   'message' => 'Product not found',
                ]);
            }
        }
        return redirect('/');
    }

    public function import() {
        return view('product.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if (!$request->hasFile('file_item')) {
                return response()->json([
                    'status' => false,
                    'message' => 'No file uploaded',
                    'msgField' => ['file_item' => ['Please select a file']]
                ]);
            }

            $rules = [
                'file_item' => ['required', 'mimes:xlsx,xls', 'max:1024']
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
                $file = $request->file('file_item');
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);

                $insert = [];
                if (count($data) > 1) {
                    foreach ($data as $row => $value) {
                        if ($row > 1) {
                            $insert[] = [
                                'id_category' => $value['A'],
                                'product_code' => $value['B'],
                                'product_name' => $value['C'],
                                'purchase_price' => $value['D'],
                                'selling_price' => $value['E'],
                                'created_at' => now(),
                                'updated_at' => now()
                            ];
                        }
                    }

                    if (count($insert) > 0) {
                        ProductModel::insertOrIgnore($insert);
                        return response()->json([
                            'status' => true,
                            'message' => 'Data imported successfully'
                        ]);
                    }
                }

                return response()->json([
                    'status' => false,
                    'message' => 'No data imported'
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

    public function export_excel() {
        $product = ProductModel::select('id_category', 'product_code', 'product_name', 'purchase_price','selling_price')
            ->orderBy('id_category')
            ->with('category')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID Category');
        $sheet->setCellValue('B1', 'Product Code');
        $sheet->setCellValue('C1', 'Product Name');
        $sheet->setCellValue('D1', 'Purchase Price');
        $sheet->setCellValue('E1', 'Selling Price');
        $sheet->setCellValue('F1', 'Category Name');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $num = 1;
        $row = 2;

        foreach ($product as $key => $value) {
            $sheet->setCellValue('A' . $row, $value->id_category);
            $sheet->setCellValue('B' . $row, $value->product_code);
            $sheet->setCellValue('C' . $row, $value->product_name);
            $sheet->setCellValue('D' . $row, $value->purchase_price);
            $sheet->setCellValue('E'. $row, $value->selling_price);
            $sheet->setCellValue('F'. $row, $value->category->name_category);
            $row++;
            $num++;
        }

        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Product Data');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Product Data ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf() {
        $products = ProductModel::select('id_category', 'product_code', 'product_name', 'purchase_price','selling_price')
            ->orderBy('id_category')
            ->with('category')
            ->get();

        $pdf = Pdf::loadView('product.export_pdf', compact('products'));
        $pdf->setPaper('a4', 'portrait');
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->render();

        return $pdf->stream('Product Data '.date('Y-m-d H:i:s').'.pdf');
    }
}
