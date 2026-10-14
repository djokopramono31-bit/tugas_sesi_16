<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('products', ProductController::class)
    ->names('products');

Route::resource('categories', ProductCategoryController::class)
    ->names('categories');
