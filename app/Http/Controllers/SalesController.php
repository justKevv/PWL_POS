<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\Sales;
use App\Models\SalesDetail;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = (object) [
            'title' => 'Sales List',
            'list' => ['Home', 'Sales'],
        ];

        $page = (object) [
            'title' => 'list of sales registered in the system',
        ];

        $user = UserModel::whereIn('id_level', [2, 3])->get();

        $activeMenu = 'sales';

        return view('sales.index', compact('breadcrumbs', 'page', 'activeMenu', 'user'));
    }

    public function list(Request $request)
    {
        $sales = Sales::select('id_sales', 'sales_code', 'buyer', 'sales_date', 'id_user')
            ->with('user')->orderBy('sales_date', 'desc');

        if ($request->id_user) {
            $sales = $sales->where('id_user', $request->id_user);
        }

        return DataTables::of($sales)
            ->addIndexColumn()
            ->addColumn('action', function ($sale) {
                $btn = '<a href="' . url('/sales/' . $sale->id_sales) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/sales/' . $sale->id_sales . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/sales/' . $sale->id_sales) . '">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Did you delete this data?\');">Delete</button></form>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getNextCode($date)
    {
        $dateParts = explode('-', $date);
        $year = $dateParts[0];
        $month = $dateParts[1];
        $day = $dateParts[2];

        $lastSale = Sales::where('sales_code', 'LIKE', "SALE/$year/$month/$day/%")
            ->orderBy('sales_code', 'desc')
            ->first();

        $nextCode = 1;
        if ($lastSale) {
            $lastNumber = intval(substr($lastSale->sales_code, -3));
            $nextCode = $lastNumber + 1;
        }

        return response()->json(['next_code' => $nextCode]);
    }

    public function getProductPrice($id_product) {
        $product = ProductModel::find($id_product);
        if ($product) {
            return response()->json(['price' => $product->selling_price]);
        } else {
            return response()->json(['price' => 0]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = (object) [
            'title' => 'Add Sales',
            'list' => ['Home', 'Sales', 'Add'],
        ];

        $page = (object) [
            'title' => 'Add New Sales',
        ];

        $user = UserModel::whereIn('id_level', [2, 3])->get();
        $product = ProductModel::all();
        $activeMenu = 'sales';

        return view('sales.create', compact('breadcrumbs', 'page', 'activeMenu', 'user', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sales_code' => 'required|string|max:50|unique:t_sales,sales_code',
            'buyer' => 'required|string|max:50',
            'id_product.*' =>'required|integer',
            'price.*' =>'required|integer',
            'qty.*' =>'required|integer',
            'sales_date' => 'required|date',
            'sales_date_time' => 'required',
            'id_user' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $sales = Sales::create([
                'sales_code' => $request->sales_code,
                'buyer' => $request->buyer,
                'sales_date' => $request->sales_date_time,
                'id_user' => $request->id_user,
            ]);

            foreach ($request->id_product as $key => $product_id) {
                $detail = SalesDetail::create([
                    'id_sales' => $sales->id_sales,
                    'id_product' => $product_id,
                    'price' => $request->price[$key],
                    'qty' => $request->qty[$key],
                ]);
            }

            DB::commit();
            return redirect('/sales')->with('success', 'Sales has been added');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/sales')->with('error', 'Sales cannot be added');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sales)
    {
        $breadcrumbs = (object) [
            'title' => 'Sales Detail',
            'list' => ['Home', 'Sales', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Sales Detail',
        ];

        $sales->load('user');
        $sales->load('detail');

        $activeMenu = 'sales';

        return view('sales.show', compact('breadcrumbs', 'page', 'activeMenu', 'sales'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        $breadcrumbs = (object) [
            'title' => 'Add Sales',
            'list' => ['Home', 'Sales', 'Add'],
        ];

        $page = (object) [
            'title' => 'Add New Sales',
        ];

        $user = UserModel::whereIn('id_level', [2, 3])->get();
        $product = ProductModel::all();
        $activeMenu = 'sales';

        return view('sales.edit', compact('breadcrumbs', 'page', 'activeMenu', 'user', 'product', 'sales'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        $request->validate([
            'sales_code' => 'required|string|max:50|unique:t_sales,sales_code,' . $sales->id_sales . ',id_sales',
            'buyer' => 'required|string|max:50',
            'id_product.*' =>'required|integer',
            'price.*' =>'required|integer',
            'qty.*' =>'required|integer',
            'sales_date' => 'required|date',
            'sales_date_time' => 'required',
            'id_user' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $sales->update([
               'sales_code' => $request->sales_code,
                'buyer' => $request->buyer,
               'sales_date' => $request->sales_date_time,
                'id_user' => $request->id_user,
            ]);

            SalesDetail::where('id_sales', $sales->id_sales)->delete();

            foreach ($request->id_product as $key => $product_id) {
                SalesDetail::create([
                    'id_sales' => $sales->id_sales,
                    'id_product' => $product_id,
                    'price' => $request->price[$key],
                    'qty' => $request->qty[$key],
                ]);
            }
            DB::commit();
            return redirect('/sales')->with('success', 'Sales has been updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('/sales')->with('error', 'Sales cannot be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales, SalesDetail $salesDetail)
    {
        try {
            $salesDetail->where('id_sales', $sales->id_sales)->delete();
            $sales->delete();
            return redirect('/sales')->with('success', 'Sales has been deleted');
        } catch (\Throwable $th) {
            return redirect('/sales')->with('error', 'Sales cannot be deleted');
        }
    }


}
