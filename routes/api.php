<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AdditionController;
use App\Http\Controllers\api\DiscountCodeController;
use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderItemController;
use App\Http\Controllers\api\ItemAdditionController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('addition',AdditionController::class);
Route::resource('item',ItemController::class);
Route::resource('order',OrderController::class);
Route::resource('orderItem',OrderItemController::class);
Route::resource('itemAddition',ItemAdditionController::class);
Route::resource('discountCode',DiscountCodeController::class);
