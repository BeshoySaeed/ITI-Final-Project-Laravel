<?php

namespace App\Http\Controllers;

use App\Models\CustomerServicePhone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerServicePhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerServicePhone = CustomerServicePhone::all();
        return response()->json([
            "data" => $customerServicePhone,
            'status' => 'success',
        ], 200);
    }

    public function activePhones()
    {
        $customerServicePhone = CustomerServicePhone::where('active', '1')->get();
        return response()->json([
            "data" => $customerServicePhone,
            'status' => 'success',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "phone" => ["required", "regex:/^(\+20-1)[0-9]{9}$/"],
            "active"=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $customerServicePhone = CustomerServicePhone::create($request->all());
        return response()->json([
            "data" => $customerServicePhone,
            'status' => 'success',
            'message' => 'Customer service phone created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerServicePhone $customerServicePhone)
    {
        return response()->json([
            "data" => $customerServicePhone,
            'status' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerServicePhone $customerServicePhone)
    {
        $validator = Validator::make($request->all(), [
            'phone'=>['required', "regex:/^(\+20-1)[0-9]{9}$/"],
            "active"=>"required"
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $customerServicePhone->update($request->all());
        return response()->json([
            "data" => $customerServicePhone,
            'status' => 'success',
            'message' => 'Customer service phone updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerServicePhone $customerServicePhone)
    {
        $customerServicePhone->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Customer service phone deleted successfully'
        ], 200);
    }
}
