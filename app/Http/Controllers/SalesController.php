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

        $user = UserModel::select('id_user', 'username')->whereIn('id_user', Sales::select('id_user'))->get();

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
                $btn = '<button onclick="modalAction(\'' . url('/sales/' . $sale->id_sales . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/sales/' . $sale->id_sales . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/sales/' . $sale->id_sales . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create_ajax()
    {
        $product = ProductModel::all();
        $user = UserModel::all();
        return view('sales.create_ajax', compact('product', 'user'));
    }

    public function store_ajax(Request $request)
    {
        try {
            DB::beginTransaction();

            $sales = Sales::create([
                'sales_code' => $request->sales_code,
                'buyer' => $request->buyer,
                'id_user' => $request->id_user,
                'sales_date' => $request->sales_date_time,
            ]);

            foreach ($request->id_product as $key => $id_product) {
                SalesDetail::create([
                    'id_sales' => $sales->id_sales,
                    'id_product' => $id_product,
                    'qty' => $request->qty[$key],
                    'price' => $request->price[$key],
                ]);
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Sales created successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Failed to create sales']);
        }
    }

    public function show_ajax(Sales $sales)
    {
        $sales->load('user', 'detail.product');
        return view('sales.show_ajax', compact('sales'));
    }

    public function edit_ajax(Sales $sales)
    {
        $sales->load('detail.product');
        $product = ProductModel::all();
        $user = UserModel::all();
        return view('sales.edit_ajax', compact('sales', 'product', 'user'));
    }

    public function update_ajax(Request $request, Sales $sales)
    {
        try {
            DB::beginTransaction();

            $sales->update([
                'buyer' => $request->buyer,
                'id_user' => $request->id_user,
                'sales_date' => $request->sales_date_time,
            ]);

            // Delete existing details
            $sales->detail()->delete();

            // Create new details
            foreach ($request->id_product as $key => $id_product) {
                SalesDetail::create([
                    'id_sales' => $sales->id_sales,
                    'id_product' => $id_product,
                    'qty' => $request->qty[$key],
                    'price' => $request->price[$key],
                ]);
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Sales updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Failed to update sales']);
        }
    }

    public function confirm_ajax(Sales $sales)
    {
        return view('sales.confirm_ajax', compact('sales'));
    }

    public function delete_ajax(Sales $sales)
    {
        try {
            DB::beginTransaction();

            // Delete details first
            $sales->detail()->delete();

            // Then delete the sales
            $sales->delete();

            DB::commit();
            return response()->json(['status' => true, 'message' => 'Sales deleted successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => 'Failed to delete sales']);
        }
    }

    public function getNextCode($date)
    {
        $date = date('Y-m-d', strtotime($date));
        $lastSales = Sales::whereDate('sales_date', $date)->latest()->first();

        if ($lastSales) {
            $lastCode = explode('/', $lastSales->sales_code);
            $nextCode = intval(end($lastCode)) + 1;
        } else {
            $nextCode = 1;
        }

        return response()->json(['next_code' => $nextCode]);
    }

    public function getProductPrice($id_product)
    {
        $product = ProductModel::find($id_product);
        return response()->json(['price' => $product ? $product->selling_price : 0]);
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
