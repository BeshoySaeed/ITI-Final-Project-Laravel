<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json([
            "data" => $employee,
            'status' => 'success',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => ["required", "min:2"],
            "last_name" => ["required", "min:2"],
            "job_title" => ["required", "min:2"],
            "email" => ["required", "email"],
            "phone" => ["required", "regex:/^(\+20-1)[0-9]{9}$/"],
            "national_id" => ["required", "regex:/^[0-9]{14}$/"],
            "street" => ["min:2"],
            "area" => ["min:2"],
            "city" => ["min:2"],
            "country" => ["min:2"],
            "salary" => ["regex:/^\d+$/"],
            "branch_id" => ["exists:branches,id"],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $employee = Employee::create($request->all());
        return response()->json([
            "data" => $employee,
            'status' => 'success',
            'message' => 'Employee created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json([
            "data" => $employee,
            'status' => 'success',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validator = Validator::make($request->all(), [
            "first_name" => ["required", "min:2"],
            "last_name" => ["required", "min:2"],
            "job_title" => ["required", "min:2"],
            "email" => ["required", "email"],
            "joined_at" => ["required"],
            "phone" => ["required", "regex:/^(\+20-1)[0-9]{9}$/"],
            "national_id" => ["required", "regex:/^[0-9]{14}$/"],
            "street" => ["min:2"],
            "area" => ["min:2"],
            "city" => ["min:2"],
            "salary" => ["regex:/^\d+$/"],
            "branch_id" => ["exists:branches,id"],
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()->all()
            ], 422);
        }

        $employee->update($request->all());
        return response()->json([
            "data" => $employee,
            'status' => 'success',
            'message' => 'Employee updated successfully'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Employee deleted successfully'
        ], 200);
    }
}
