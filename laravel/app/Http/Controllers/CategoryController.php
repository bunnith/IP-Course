<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    // GET /categories
    public function getCategories()
    {
        return response()->json(Category::all(), 200);
    }

    // POST /categories
    public function createCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    // GET /categories/{categoryId}
    public function getCategory($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            return response()->json($category, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    // PATCH /categories/{categoryId}
    public function updateCategory(Request $request, $categoryId)
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
            ]);

            $category = Category::findOrFail($categoryId);
            $category->update($validated);
            return response()->json($category, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    // DELETE /categories/{categoryId}
    public function deleteCategory($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }
}
