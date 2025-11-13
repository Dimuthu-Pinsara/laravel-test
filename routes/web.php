<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);
Route::post('/save', [ProductController::class, 'store']);
Route::post('/update', [ProductController::class, 'update']);