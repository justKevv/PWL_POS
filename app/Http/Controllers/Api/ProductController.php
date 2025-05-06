<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the category relationship
        return response()->json(ProductModel::with('category')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_code' => ['required', 'string', 'unique:m_product,product_code'],
            'product_name' => ['required', 'string', 'max:100'],
            'id_category' => ['required', 'integer', 'exists:m_category,id_category'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product = ProductModel::create($validator->validated());
        $product->load('category'); // Load the relationship for the response

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductModel $product)
    {
        return response()->json($product->load('category'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductModel $product)
    {
        $validator = Validator::make($request->all(), [
            'product_code' => ['required', 'string', Rule::unique('m_product', 'product_code')->ignore($product->id_product, 'id_product')],
            'product_name' => ['required', 'string', 'max:100'],
            'id_category' => ['required', 'integer', 'exists:m_category,id_category'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $product->update($validator->validated());
        $product->load('category'); // Reload relationship

        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductModel $product)
    {
        // Add check if product is in use (e.g., sales details) before deleting?
        try {
            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product Deleted Successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log error
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product.'
            ], 500);
        }
    }
}
