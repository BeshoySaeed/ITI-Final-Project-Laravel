<?php

namespace App\Http\Controllers;

use App\Models\UserFavourite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use UserFactory;

class UserFavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {
        $user_favourites = UserFavourite::where('user_id', $user_id)->get()->all();

        return response()->json([
            "data" => $user_favourites,
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
            "item_id" => "required|exists:items,id",
        ]);

        if($validator->fails()) {
            return response()->json([
                "status" => "failed",
                "message" => $validator->errors()->all()
            ], 422);
        }

        $user_favorite = UserFavourite::create($request->all());
        return response()->json([
            "data" => $user_favorite,
            'status' => 'success',
            'message' => 'User favorite created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserFavourite $userFavourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserFavourite $userFavourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserFavourite $userFavourite)
    {
        $userFavourite->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User favorite deleted successfully'
        ], 200);
    }
}
