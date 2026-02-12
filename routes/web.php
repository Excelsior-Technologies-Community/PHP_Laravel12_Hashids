<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HashidsController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/encode/{id}', [HashidsController::class, 'encode']);
Route::get('/decode/{hash}', [HashidsController::class, 'decode']);
