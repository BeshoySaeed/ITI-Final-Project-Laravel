<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ItemAddition;
use Illuminate\Http\Request;
use App\Http\Resources\ItemAdditionResource;
use Illuminate\Support\Facades\Validator;



class ItemAdditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemAddition = ItemAddition::all();
        return ItemAdditionResource::collection($itemAddition);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "item_id"=>"required",
            "addition_id"=>"required",
    
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
        $itemAddition = ItemAddition::create($request->all());
        return new ItemAdditionResource ($itemAddition);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemAddition $itemAddition)
    {
        return new ItemAdditionResource($itemAddition) ;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemAddition $itemAddition)
    {
        $itemAddition->update($request->all());
        return new ItemAdditionResource ($itemAddition);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemAddition $itemAddition)
    {
        $itemAddition->delete();
        return response("Deleted", 204);
    }
}
