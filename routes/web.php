<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeApplicationController;
use Illuminate\Support\Facades\Route;
USE Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

/* Route::get('/', function () {
    return view('welcome');
});
 */
Route::get('/home/dashboard', function () {
    return view('dashboard');
});
/* Auth::routes();
 */
Route::resource('/ingredient_activex_product_table', App\Http\Controllers\IngredientActiveXProductController::class)->middleware('auth');
Route::resource('/ingredient_active_table', App\Http\Controllers\IngredientActiveController::class)->middleware('auth');
Route::resource('/type_product_table', App\Http\Controllers\TypeProductController::class)->middleware('auth');
Route::resource('/biologic_table', App\Http\Controllers\BiologicController::class)->middleware('auth');
Route::resource('/unit_meansure', App\Http\Controllers\UnitMeasureController::class)->middleware('auth');
Route::resource('/products_table', App\Http\Controllers\ProductController::class)->middleware('auth');
Route::get('/products_tablel', [ProductController::class, 'index'])->name('products_input')->middleware('auth');
Route::resource('/type_application_table',App\Http\Controllers\TypeApplicationController::class)->middleware('auth');
Route::resource('/biolog_x_product',App\Http\Controllers\BlancoBiolProdController::class)->middleware('auth');

Route::get('/{view?}', [HomeController::class,'index'])->where('view','(.*)');
