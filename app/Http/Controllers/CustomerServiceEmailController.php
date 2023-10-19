<?php

namespace App\Http\Controllers;

use App\Models\CustomerServiceEmail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerServiceEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerServiceEmail = CustomerServiceEmail::all();
        return response()->json([
            "data" => $customerServiceEmail,
            "status" => "success"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>['required', "email", Rule::unique('customer_service_emails')],
            "active"=>"required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"=> "failed",
                "message"=> $validator->errors()
            ],422);
        }

        $customerServiceEmail = CustomerServiceEmail::create($request->all());
        return response()->json([
            "data" => $customerServiceEmail,
            "status"=> "success",
            'message' => 'Customer service email created successfully'
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerServiceEmail $customerServiceEmail)
    {
        return response()->json([
            "data" => $customerServiceEmail,
            'status' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerServiceEmail $customerServiceEmail)
    {
        $validator = Validator::make($request->all(), [
            'email'=>['required', "email"],
            "active"=>"required"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status"=> "failed",
                "message"=> $validator->errors()
            ],422);
        }

        $customerServiceEmail->update($request->all());
        return response()->json([
            "data" => $customerServiceEmail,
            "status"=> "success",
            'message' => 'Customer service email updated successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerServiceEmail $customerServiceEmail)
    {
        $customerServiceEmail->delete();
        return response()->json([
            "status" => "success",
            'message' => 'Customer service email deleted successfully'
        ], 200);
    }
}
