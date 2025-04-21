<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // Added Validator
use PhpOffice\PhpSpreadsheet\IOFactory; // Added IOFactory
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
                $btn = '<button onclick="modalAction(\'' . url('/category/' . $category->id_category . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/category/' . $category->id_category . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/category/' . $category->id_category . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Delete</button> ';

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

    public function create_ajax()
    {
        return view('category.create_ajax');
    }

    public function show_ajax(CategoryModel $category)
    {
        return view('category.show_ajax', compact('category'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'code_category' =>'required|string|unique:m_category,code_category',
                'name_category' =>'required|string|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            CategoryModel::create($request->all());

            return response()->json([
               'status' => true,
               'message' => 'Category created successfully',
            ]);
        }

        redirect('/');
    }

    public function edit_ajax(CategoryModel $category)
    {
        return view('category.edit_ajax', compact('category'));
    }

    public function update_ajax(Request $request, CategoryModel $category)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'code_category' => 'required|string|unique:m_category,code_category,' . $category->id_category . ',id_category',
                'name_category' => 'required|string|max:100',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed',
                    'msgField' => $validator->errors()
                ]);
            }

            if ($category) {
                $category->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Category updated successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found',
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(CategoryModel $category)
    {
        return view('category.confirm_ajax', compact('category'));
    }

    public function delete_ajax(Request $request, CategoryModel $category)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if ($category) {
                $category->delete();
                return response()->json([
                   'status' => true,
                   'message' => 'Category deleted successfully',
                ]);
            } else {
                return response()->json([
                   'status' => false,
                   'message' => 'Category not found',
                ]);
            }
        }
        return redirect('/');
    }

    // New method to show the import modal view
    public function import() {
        return view('category.import');
    }

    // New method to handle the AJAX import request
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            if (!$request->hasFile('file_category')) {
                return response()->json([
                    'status' => false,
                    'message' => 'No file uploaded',
                    'msgField' => ['file_category' => ['Please select a file']]
                ]);
            }

            $rules = [
                'file_category' => ['required', 'mimes:xlsx,xls', 'max:2048'] // Increased max size slightly
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
                $file = $request->file('file_category');
                $reader = IOFactory::createReaderForFile($file->getRealPath()); // Use createReaderForFile for flexibility
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true);

                $insert = [];
                $errors = [];
                $rowCount = 0;

                if (count($data) > 1) { // Check if there's more than just the header row
                    foreach ($data as $row => $value) {
                        if ($row > 1) { // Start from the second row (skip header)
                            $rowCount++;
                            $rowData = [
                                'code_category' => $value['A'] ?? null, // Use null coalescing for safety
                                'name_category' => $value['B'] ?? null,
                                'created_at' => now(),
                                'updated_at' => now()
                            ];

                            if (empty($rowData['code_category']) || empty($rowData['name_category'])) {
                                $errors[] = "Row " . $row . ": Missing code or name.";
                                continue;
                            }

                            $insert[] = $rowData;
                        }
                    }

                    if (!empty($errors)) {
                         return response()->json([
                            'status' => false,
                            'message' => 'Import failed due to data errors: ' . implode(' ', $errors),
                        ]);
                    }

                    if (count($insert) > 0) {
                        CategoryModel::insertOrIgnore($insert);
                        return response()->json([
                            'status' => true,
                            'message' => count($insert) . ' categories imported successfully.'
                        ]);
                    } else {
                         return response()->json([
                            'status' => false,
                            'message' => 'No valid category data found in the file to import.'
                        ]);
                    }
                }

                return response()->json([
                    'status' => false,
                    'message' => 'The uploaded file is empty or contains only a header row.'
                ]);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                 return response()->json([
                    'status' => false,
                    'message' => 'Error reading file: ' . $e->getMessage(),
                ]);
            }

            catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Import failed due to an unexpected error.',
                ]);
            }
        }
        return redirect('/');
    }
}
