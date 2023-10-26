<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\DiscountCode;
use Illuminate\Http\Request;
use App\Http\Resources\DiscountCodeResource;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discount = DiscountCode::all();
        return DiscountCodeResource::collection($discount);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $validator = Validator::make($request->all(), [
        "code"=>"required",
        "percent"=>"required",
        "active"=>"required",
    ]);

    if($validator->fails()){
        return response($validator->errors()->all(), 422);
    }
     $discount = DiscountCode::create($request->all());
     return new DiscountCodeResource ($discount);
    }

    /**
     * Display the specified resource.
     */
    public function show(DiscountCode $discountCode)
    {
        return new DiscountCodeResource($discountCode);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiscountCode $discountCode)
    {
        $discountCode->update($request->all());
        return new DiscountCodeResource($discountCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiscountCode $discountCode)
    {
        $discountCode->delete();
        return response("Deleted", 204);
    }
}
