<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
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
            ->addIndexColumn() // add auto sort column (default column name: DT_RowIndex)
            ->addColumn('action', function ($product) { // add action column
                $btn = '<a href="' . url('/item/' . $product->id_product) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/item/' . $product->id_product . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/item/' . $product->id_product) . '">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Did you delete this data?\');">Delete</button></form>';

                return $btn;
            })
            ->rawColumns(['action']) // tells you that the action column is html
            ->make(true);
    }

    public function getNextId(CategoryModel $category) {
        $lastProduct = ProductModel::where('id_category', $category->id_category)->orderBy('product_code', 'desc')->first();

        $nextId = 1;
        if ($lastProduct) {
            $lastNumber = intval(substr($lastProduct->product_code, -3));
            $nextId = $lastNumber + 1;
        }

        return response()->json(['next_id' => $nextId]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductModel $product)
    {
        $product->delete();
        return redirect('/item')->with('success','Product has been deleted');
    }
}
