<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Public Routes
Route::post('register',[AuthController::class, 'register']);

//Authenticated Routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    //Products Routes
    Route::get('products',[ProductsController::class, 'getAllProducts'])->name('api.all.products');
    Route::post('product',[ProductsController::class, 'createNewProduct'])->name('api.create.product');
    Route::get('product/{id}',[ProductsController::class, 'getSingleProduct'])->name('api.single.product');
    Route::put('product/{id}',[ProductsController::class, 'updateProduct'])->name('api.update.product');  
    Route::delete('product/{id}',[ProductsController::class, 'deleteProduct'])->name('api.delete.product');
    Route::get('seller-products/{id}',[ProductsController::class, 'sellerProducts'])->name('api.seller.product');
    
    //Users Routes
    Route::get('users',[UserController::class, 'index']);
    Route::get('user/{id}',[UserController::class, 'show']);
    Route::put('user/{id}',[UserController::class, 'update']);
    Route::delete('user/{id}',[UserController::class, 'delete']);
    Route::post('deposit',[UserController::class, 'deposit'])->name('api.deposit');
    Route::post('buy',[UserController::class, 'buy'])->name('api.buy');
    Route::post('reset',[UserController::class, 'reset']);
});







