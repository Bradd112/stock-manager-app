<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StoragesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

// Storages
Route::post('storage', [StoragesController::class, 'store'])->name('storage.store');
Route::put('storage/{storage}', [StoragesController::class, 'update'])->name('storage.update');
Route::delete('storage/{storage}', [StoragesController::class, 'destroy'])->name('storage.destroy');

// Brands
Route::post('brand', [BrandsController::class, 'store'])->name('brand.store');
Route::put('brand/{brand}', [BrandsController::class, 'update'])->name('brand.update');
Route::delete('brand/{brand}', [BrandsController::class, 'destroy'])->name('brand.destroy');

// Products
Route::get('storage/{storage}/edit-products', [ProductsController::class, 'editStorageProducts'])->name('product.edit-storage-products');
Route::post('product', [ProductsController::class, 'store'])->name('product.store');
Route::put('product/{product}', [ProductsController::class, 'update'])->name('product.update');
Route::delete('product/{product}', [ProductsController::class, 'destroy'])->name('product.destroy');
