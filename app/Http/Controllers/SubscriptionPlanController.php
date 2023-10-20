<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptionPlan = SubscriptionPlan::all();
        return response()->json([
            "data" => $subscriptionPlan,
            'status' => 'success',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required"],
            "benefit"=>"required",
            "discount_value" => ["required"],
            "duration"=>"required",
            "subscribe_value"=>"required",
            "active"=>"required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $subscriptionPlan = SubscriptionPlan::create($request->all());
        return response()->json([
            "data" => $subscriptionPlan,
            'status' => 'success',
            'message' => 'Subscription plan created successfully'
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return response()->json([
            "data" => $subscriptionPlan,
            'status' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required"],
            "benefit"=>"required",
            "discount_value" => ["required"],
            "duration"=>"required",
            "subscribe_value"=>"required",
            "active"=>"required",
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $subscriptionPlan->update($request->all());
        return response()->json([
            "data" => $subscriptionPlan,
            'status' => 'success',
            'message' => 'Subscription plan updated successfully'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Subscription plan deleted successfully'
        ], 200);
    }
}
