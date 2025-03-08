<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// Route::get('/categories', [CategoryController::class, 'getCategories']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CategoryController::class)->prefix('categories')->group(function() {
    Route::get('/', 'getCategories'); // GET /categories
    Route::post('/', 'createCategory'); // POST /categories
    Route::get('{categoryId}', 'getCategory');
    Route::patch('{categoryId}', 'updateCategory');
    Route::delete('{categoryId}', 'deleteCategory'); // DELETE /categories/{categoryId}

});

Route::controller(ProductController::class)->prefix('products')->group(function() {
    Route::get('/', 'index'); // GET /products ✅ Correct
    Route::post('/', 'store'); // POST /products ✅ Fix: Change 'createProduct' → 'store'
    Route::get('{productId}', 'show'); // GET /products/{productId} ✅ Fix: Change 'getProduct' → 'show'
    Route::patch('{productId}', 'update'); // PATCH /products/{productId} ✅ Fix: Change 'updateProduct' → 'update'
    Route::delete('{productId}', 'destroy'); // DELETE /products/{productId} ✅ Fix: Change 'deleteProduct' → 'destroy'
});
