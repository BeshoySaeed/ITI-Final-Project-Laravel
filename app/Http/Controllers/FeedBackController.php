<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedBackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedBack = FeedBack::all();
        return response()->json([
            "data" => $feedBack,
            'status' => 'success',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required|exists:users,id",
            "rate_value"=>"required",
            "rate_comment" => "required"
        ]);

        if($validator->fails()) {
            return response()->json([
                "status" => "failed",
                "message" => $validator->errors()->all()
            ], 422);
        }

        $feedback = FeedBack::create($request->all());
        return response()->json([
            "data" => $feedback,
            'status' => 'success',
            'message' => 'Feedback created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FeedBack $feedBack)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeedBack $feedBack)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeedBack $feedBack)
    {
        
    }
}
