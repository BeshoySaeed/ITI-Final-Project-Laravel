<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Addition;
use Illuminate\Http\Request;
use App\Http\Resources\AdditionResource;
use Illuminate\Support\Facades\Validator;



class AdditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addition = Addition::all();
        return AdditionResource::collection($addition);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required",
            "img"=>"required",
            "price"=>"required",
            "description"=>"required",
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
        $addition = Addition::create($request->all());
        return new AdditionResource ($addition);
    }

    /**
     * Display the specified resource.
     */
    public function show(Addition $addition)
    {
        return new AdditionResource($addition) ;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Addition $addition)
    {
        $addition->update($request->all());
        return new AdditionResource ($addition);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addition $addition)
    {
        $addition->delete();
        return response("Deleted", 204);

    }
}
