<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware("auth:sanctum");
        $this->middleware("is_admin")->only('index', 'store', 'destroy');
    }

    public function index()
    {
        //
        $user = User::all();

        return UserResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "email"=>"required",
            "password"=>"required",
            "first_name"=>"required",
            "last_name"=>"required",

        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
   
        $user = User::create($request->all());
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return new UserResource($user);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $validator = Validator::make($request->all(), [
            "email"=>"required",
            "first_name"=>"required",
            "last_name"=>"required",
        ]);
   
        
        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
        
        $user->update($request->all());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return response("Deleted", 204);
    }
}
