<?php

use App\Http\Controllers\StorageController;
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

Route::get('/', [StorageController::class, 'index']);
Route::post('/storage', [StorageController::class, 'store'])->name('storage.store');
