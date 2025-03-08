<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // List all products
    public function index()
    {
        $products = Product::with('category')->get(); // Eager load the category relationship
        return response()->json($products);
    }

    // Create a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
              'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Product name is required.',
             'price.required' => 'Product price is required.',
             'price.numeric' => 'Product price must be a number.',
            'category_id.required' => 'Category ID is required.',
            'category_id.exists' => 'The selected category does not exist.',
        ]);

        $product = Product::create($validated);
        return response()->json($product, 201);
    }


    // Get a single product
    public function show($id)
    {
        try {
            $product = Product::with('category')->findOrFail($id);
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }


    // Update a product
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
              'price' => 'sometimes|numeric',
                'category_id' => 'sometimes|exists:categories,id',
            ]);

            $product = Product::findOrFail($id);
            $product->update($validated);

            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    // Delete a product
    public function destroy($id)
{
    try {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Product not found'], 404);
    }
}
}
