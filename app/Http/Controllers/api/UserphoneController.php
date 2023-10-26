<?php

namespace App\Http\Controllers\api;

use App\Models\UserPhone;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserphoneResource;
use Illuminate\Support\Facades\Validator;

class UserphoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $phone = UserPhone::all();

        return UserphoneResource::collection($phone);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "phone"=> "required",
            "user_id"=> "required"
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
   
        $phone = UserPhone::create($request->all());
       // $phone->user_id = Auth::id();   
       $phone->save();

        return (new UserphoneResource($phone))->response()->setStatusCode(201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(UserPhone $userPhone)
    {
        //
        return new UserphoneResource($userPhone);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserPhone $userPhone)
    {
        //
        $validator = Validator::make($request->all(), [
            "phone"=> "required",
          
        ]);
   
        
        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
        
        $userPhone->update($request->all());

        return new UserphoneResource($userPhone);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserPhone $userPhone)
    {
        //
        $userPhone->delete();
        return response("Deleted", 204);
    }
}
