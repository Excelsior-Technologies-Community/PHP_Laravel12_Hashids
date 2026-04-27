<?php

use App\Http\Controllers\Api\ProductApiController;

Route::get('/products', [ProductApiController::class, 'index']);

