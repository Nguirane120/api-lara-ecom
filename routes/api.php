<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ViewCategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('users', [AuthController::class, 'getUsers']);

Route::get('view-category', [ViewCategoryController::class, 'category']);
Route::get('getProduct/{slug}', [ViewCategoryController::class, 'product']);
Route::get('product-detail/{category_slug}/{product_slug}', [ViewCategoryController::class, 'productDetail']);


Route::get('show-category', [CategoryController::class, 'index']);
Route::post('add-category', [CategoryController::class, 'store']);
Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
Route::put('update-category/{id}', [CategoryController::class, 'update']);
Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);

Route::get('all-product', [ProductController::class, 'index']);
Route::post('add-product', [ProductController::class, 'store']);
Route::get('edit-product/{id}', [ProductController::class, 'edit']);
Route::post('update-product/{id}', [ProductController::class, 'update']);


Route::post('add-to-cart', [CartController::class, 'addTocart']);
Route::get('carts', [CartController::class, 'getCart']);
Route::put('update-carteQty/{cart_id}/{scoop}', [CartController::class, 'updateQty']);
Route::delete('delete-Item/{cart_id}', [CartController::class, 'deleteCartItem']);



Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
    Route::get('/checkAuthenticated', function () {
        return response()->json(['message' => 'Youare in', 'status' => 200], 200);
    });

    // Route::get('show-category', [CategoryController::class, 'index']);
    // Route::post('add-category', [CategoryController::class, 'store']);
    // Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
    // Route::put('update-category/{id}', [CategoryController::class, 'update']);
    // Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);

    // Route::get('all-product', [ProductController::class, 'index']);
    // Route::post('add-product', [ProductController::class, 'store']);
    // Route::get('edit-product/{id}', [ProductController::class, 'edit']);
    // Route::post('update-product/{id}', [ProductController::class, 'update']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });