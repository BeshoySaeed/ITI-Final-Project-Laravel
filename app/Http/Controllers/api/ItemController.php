<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Models\ItemAddition;
use Illuminate\Support\Facades\Validator;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware("is_admin")->only('store', 'update', 'destroy');
    }

    public function index()
    {
        $item = Item::all();
        return ItemResource::collection($item);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name"=>"required",
            "image"=>"required",
            "price"=>"required",
            "description"=>"required",
            "category_id"=>"required",
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }

        $item = Item::create($request->all());
        $this->storeItemAdditions($request->additions, $item->id);

        return new ItemResource ($item);
    }

    public function storeItemAdditions($additions, $item_id)
    {
        foreach ($additions as $addition) {
            ItemAddition::create([
                'item_id' => $item_id,
                'addition_id' => $addition['id'],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return new ItemResource($item) ;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        // dd($request->all());
        $item->update($request->all());
        return new ItemResource ($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response("Deleted", 204);
    }
}
