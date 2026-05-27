<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HashidsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\ProductApiController;

// Basic Hashids routes
Route::get('/encode/{id}', [HashidsController::class, 'encode']);
Route::get('/decode/{hash}', [HashidsController::class, 'decode']);

// Product routes with better naming
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    Route::post('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
    Route::get('/export/csv', [ProductController::class, 'export'])->name('export');
});

// API routes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/products', [ProductApiController::class, 'index'])->name('products.index');
    Route::get('/products/{hashid}', [ProductApiController::class, 'show'])->name('products.show');
    Route::post('/products/batch-decode', [ProductApiController::class, 'batchDecode'])->name('products.batch-decode');
});