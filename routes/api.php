<?php

use App\Http\Controllers\CustomerServiceEmailController;
use App\Http\Controllers\CustomerServicePhoneController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\SocialMediaAccountController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\UserFavouriteController;
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
Route::get('user-favourites/{user_id}', [UserFavouriteController::class, 'index']);
Route::apiResource('user-favourites', UserFavouriteController::class);
Route::apiResource('feedbacks', FeedBackController::class);
Route::apiResource('subscription-plans', SubscriptionPlanController::class);
Route::apiResource('employees', EmployeeController::class);