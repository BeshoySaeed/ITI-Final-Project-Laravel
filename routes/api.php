<?php

use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\JopApplicantController;
use App\Http\Controllers\Api\PartnerController;
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


Route::apiResource('contact-us', ContactUsController::class);

Route::apiResource("partners", PartnerController::class);

Route::apiResource("jobApplicants", JopApplicantController::class);

Route::apiResource("branches", BranchController::class);
