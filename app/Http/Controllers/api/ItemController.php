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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "image" => "required",
            "price" => "required",
            "description" => "required",
            "category_id" => "required",
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        
        $path = public_path('images/item');
        !is_dir($path) &&
            mkdir($path, 7777, true);


        $imageName = time() . '.' . $request->file('image')->extension();
        $request->file('image')->move($path, $imageName);

        $fullRequest = $request->all();
        $fullRequest['image'] = $imageName;
        

        $item = Item::create($fullRequest);
        $itemAdditionsArray = json_decode($request->additions, true);
        $this->storeItemAdditions($itemAdditionsArray, $item->id);

        return new ItemResource($item);
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
        $item->update($request->all());
        return new ItemResource ($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {

        //  $product = Product::findorfail($id);
        // $product->delete();
    $image_path=public_path('images/item/'. $item->image);
    if(file_exists($image_path)){
        unlink($image_path);
        $item->delete();
    }
    $item->delete();


// dd($image_path);
        // unlink('images/item/'. $item->img);

        return response("Deleted", 204);
    }
}