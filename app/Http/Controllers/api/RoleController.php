<?php

namespace App\Http\Controllers\api;

use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RoleResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $role = Role::all();

        return RoleResource::collection($role);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            "role"=> "required|in:user,admin,employee"
           
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
   
        $role = Role::create($request->all());
        $role->save();

        return (new RoleResource($role))->response()->setStatusCode(201);  
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        return new RoleResource($role);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $validator = Validator::make($request->all(), [
            "role"=> "required|in:user,admin,employee"
          
        ]);
   
        
        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
        
        $role->update($request->all());

        return new RoleResource($role);
    }

    /** 
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();
        return response("Deleted", 204);
    }
}
