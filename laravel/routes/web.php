<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/upload', [UploadController::class, 'showForm'])->name('upload.form');
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

Route::get('/upload-image', [ImageController::class, 'create']);
Route::post('/upload-image', [ImageController::class, 'store'])->name('upload.image');
Route::get('/gallery', [ImageController::class, 'gallery'])->name('gallery');

require __DIR__.'/auth.php';
