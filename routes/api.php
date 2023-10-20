<?php

use App\Http\Controllers\CustomerServiceEmailController;
use App\Http\Controllers\CustomerServicePhoneController;
use App\Http\Controllers\SocialMediaAccountController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('customer-service-phones', CustomerServicePhoneController::class);
Route::apiResource('customer-service-emails', CustomerServiceEmailController::class);
Route::apiResource('social-media-accounts', SocialMediaAccountController::class);