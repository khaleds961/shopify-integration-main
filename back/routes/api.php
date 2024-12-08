<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopifyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products/{productId}/push', [ProductController::class, 'pushToShopify']);
    Route::get('/userAccess',[AuthController::class,'userAccess']);
});


Route::get('/shopify/redirect', [ShopifyController::class, 'redirectToShopify']);
Route::get('/callback', [ShopifyController::class, 'handleCallback'])->name('shopify.callback');
