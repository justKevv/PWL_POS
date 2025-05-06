<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CategoryModel::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_category' => ['required', 'string', 'unique:m_category,code_category'],
            'name_category' => ['required', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = CategoryModel::create($validator->validated());
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryModel $category)
    {
        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryModel $category)
    {
        $validator = Validator::make($request->all(), [
            'code_category' => ['required', 'string', Rule::unique('m_category', 'code_category')->ignore($category->id_category, 'id_category')],
            'name_category' => ['required', 'string', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->update($validator->validated());
        return response()->json($category, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryModel $category)
    {
        // Add check if category is in use by products before deleting?
        try {
            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category Deleted Successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log error
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category.'
            ], 500);
        }
    }
}