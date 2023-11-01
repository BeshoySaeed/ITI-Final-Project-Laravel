<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\JopApplicantController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\ChangePasswordController;

use App\Http\Controllers\CustomerServiceEmailController;
use App\Http\Controllers\CustomerServicePhoneController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\SocialMediaAccountController;
use App\Http\Controllers\SubscriptionPlanController;
use App\Http\Controllers\UserFavouriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AdditionController;
use App\Http\Controllers\api\DiscountCodeController;
use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\OrderItemController;
use App\Http\Controllers\api\ItemAdditionController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\RoleController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\UserphoneController;
use App\Http\Controllers\api\UserAddressController;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use App\Models\UserPhone;
use App\Models\UserAddress;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
    Route::post('profile', 'profile')->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('contact-us', ContactUsController::class);

Route::apiResource("partners", PartnerController::class);

Route::apiResource("jobApplicants", JopApplicantController::class);

Route::apiResource("branches", BranchController::class);

Route::apiResource('customer-service-phones', CustomerServicePhoneController::class)->middleware('is_admin');
Route::get('customer-service-active-phones', [CustomerServicePhoneController::class, 'activePhones']);

Route::apiResource('customer-service-emails', CustomerServiceEmailController::class)->middleware('is_admin');
Route::get('customer-service-active-emails', [CustomerServiceEmailController::class, 'activeEmails']);

Route::apiResource('social-media-accounts', SocialMediaAccountController::class);
Route::get('user-favourites/{user_id}', [UserFavouriteController::class, 'index'])->middleware("auth:sanctum");
Route::apiResource('user-favourites', UserFavouriteController::class)->middleware("auth:sanctum");
Route::apiResource('feedbacks', FeedBackController::class);

Route::apiResource('subscription-plans', SubscriptionPlanController::class)->middleware("is_admin");
Route::get('subscription-plans-active', [SubscriptionPlanController::class, 'activeSubscriptions']);

Route::apiResource('employees', EmployeeController::class)->middleware("is_admin");

Route::resource('addition',AdditionController::class)->middleware("is_admin");
Route::resource('item',ItemController::class);
Route::resource('order',OrderController::class);
Route::get('cart', [OrderController::class, 'cart']);
Route::put('update-cart', [OrderController::class, 'updateCart']);
Route::delete('update-cart/{id}', [OrderController::class, 'deleteItemAdditionCart']);
Route::resource('orderItem',OrderItemController::class)->middleware("auth:sanctum");
Route::resource('itemAddition',ItemAdditionController::class);
Route::resource('discountCode',DiscountCodeController::class)->middleware("is_admin");


Route::apiResource('categories', CategoryController::class);
Route::apiResource('roles', RoleController::class)->middleware("is_admin");
Route::apiResource('users', UserController::class);
Route::apiResource('userPhone', UserphoneController::class);
Route::apiResource('userAddress', UserAddressController::class);
Route::post('/forget-password',[ResetPasswordController::class ,'forgetPass']);
Route::post('/change-password',[ChangePasswordController::class ,'changepass']);


