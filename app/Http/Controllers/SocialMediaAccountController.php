<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaAccount;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialMediaAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware("is_admin")->except('index');
    }

    public function index()
    {
        $socialMediaAccount = SocialMediaAccount::all();
        return response()->json([
            "data" => $socialMediaAccount,
            "status" => "success"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ['required'],
            "link" => ['required', 'regex:/^https:\/\//i']
        ]);

        if($validator->fails()) {
            return response()->json([
                "status" => "failed",
                "message" => $validator->errors()->all()
            ], 422);
        }
        $socialMediaAccount = SocialMediaAccount::create($request->all());

        return response()->json([
            "data" => $socialMediaAccount,
            "status" => "success",
            "message" => 'Social media account created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SocialMediaAccount $socialMediaAccount)
    {
        return response()->json([
            "data" => $socialMediaAccount,
            "status" => "success"
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialMediaAccount $socialMediaAccount)
    {
        $validator = Validator::make($request->all(), [
            "link" => ['required', 'regex:/^https:\/\//i']
        ]);

        if($validator->fails()) {
            return response()->json([
                "status" => "failed",
                "message" => $validator->errors()->all()
            ], 422);
        }
        $socialMediaAccount->update($request->all());

        return response()->json([
            "data" => $socialMediaAccount,
            "status" => "success",
            "message" => 'Social media account updated successfully'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialMediaAccount $socialMediaAccount)
    {
        $socialMediaAccount->delete();
        return response()->json([
            "status" => "success",
            "message" => "Social media account deleted successfully"
        ], 200);
    }
}
