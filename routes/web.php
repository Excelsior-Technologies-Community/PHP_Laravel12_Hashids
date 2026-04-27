<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HashidsController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/encode/{id}', [HashidsController::class, 'encode']);
Route::get('/decode/{hash}', [HashidsController::class, 'decode']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/create', [ProductController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);

Route::get('/products/{hash}', [ProductController::class, 'show']);