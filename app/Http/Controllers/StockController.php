<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\StockModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
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
        $stocks = StockModel::select('id_stock', 'date_stock', 'stock_quantity', 'id_product', 'id_user')->with('product')->with('user');

        return DataTables::of($stocks)
            ->addIndexColumn() // add auto sort column (default column name: DT_RowIndex)
            ->addColumn('action', function ($stock) { // add action column
                $btn = '<a href="' . url('/stock/' . $stock->id_stock) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stock/' . $stock->id_stock . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/stock/' . $stock->id_stock) . '">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Did you delete this data?\');">Delete</button></form>';

                return $btn;
            })
            ->rawColumns(['action']) // tells you that the action column is html
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
}
