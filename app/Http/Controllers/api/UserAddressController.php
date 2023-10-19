<?php

namespace App\Http\Controllers\api;

use App\Models\UserAddress;
use App\Models\User;
use App\Http\Resources\UserAddressResource;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $address = UserAddress::all();

        return UserAddressResource::collection($address);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "user_id"=>"required",
            "street"=> "required",
            "area"=> "required",
            "city"=> "required",
            "building_name"=> "required",
            "floor_number"=> "required",
            "flat_number"=> "required",
         
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
   
        $address = UserAddress::create($request->all());
        $address->save();

        return (new UserAddressResource($address))->response()->setStatusCode(201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAddress $userAddress)
    {
        //
        return new UserAddressResource($userAddress);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $userAddress)
    {
        //
        $validator = Validator::make($request->all(), [
            "street"=> "required",
            "area"=> "required",
            "city"=> "required",
            "building_name"=> "required",
            "floor_number"=> "required",
            "flat_number"=> "required",
        ]);
   
        
        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
        
        $userAddress->update($request->all());

        return new UserAddressResource($userAddress);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $userAddress)
    {
        //
        $userAddress->delete();
        return response("Deleted", 204);
    }
}
