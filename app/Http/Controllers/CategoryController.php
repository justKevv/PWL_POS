<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = (object) [
            'title' => 'Category List',
            'list' => ['Home', 'Category'],
        ];

        $page = (object) [
            'title' => 'list of category registered in the system',
        ];

        $activeMenu = 'category';

        return view('category.index', compact('page', 'breadcrumbs', 'activeMenu'));
    }

    public function list(Request $request) {
        $category = CategoryModel::all();

        return DataTables::of($category)
            ->addIndexColumn()
            ->addColumn('action', function ($category) { // add action column
                $btn = '<a href="' . url('/category/' . $category->id_category) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/category/' . $category->id_category . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/category/' . $category->id_category) . '">
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
            'title' => 'Add Category',
            'list' => ['Home', 'Category', 'Add'],
        ];

        $page = (object) [
            'title' => 'Add New Category',
        ];

        $activeMenu = 'category';

        return view('category.create', compact('breadcrumbs','page', 'activeMenu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code_category' => 'required|string|unique:m_category,code_category',  // username must be filled, string type, minimum 3 characters, and unique in m_user table username column
            'name_category' => 'required|string|max:100',  // name must be filled, string type, and maximum 100 characters
        ]);

        $category = CategoryModel::create([
            'code_category' => $request->code_category,
            'name_category' => $request->name_category,
        ]);

        return redirect('/category')->with('success', 'Category added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryModel $category)
    {
        $breadcrumbs = (object) [
            'title' => 'Category Detail',
            'list' => ['Home', 'Category', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Category Detail',
        ];

        $activeMenu = 'category';

        return view('category.show', compact('breadcrumbs','page', 'category','activeMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryModel $category)
    {
        $breadcrumbs = (object) [
            'title' => 'Edit Category',
            'list' => ['Home', 'Category', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit Category',
        ];

        $activeMenu = 'category';

        return view('category.edit', compact('breadcrumbs','page','activeMenu','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryModel $category)
    {
        $request->validate([
            'code_category' => 'required|string|unique:m_category,code_category',  // username must be filled, string type, minimum 3 characters, and unique in m_user table username column
            'name_category' => 'required|string|max:100',  // name must be filled, string type, and maximum 100 characters
        ]);

        $category->update([
            'code_category' => $request->code_category,
            'name_category' => $request->name_category,
        ]);

        return redirect('/category')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryModel $category)
    {
        $category->delete();
        return redirect('/category')->with('success', 'Category deleted successfully');
    }
}
