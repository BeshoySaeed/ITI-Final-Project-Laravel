<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Resources\OrderItemResource;
use Illuminate\Support\Facades\Validator;

class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderItem = OrderItem::all();
        return OrderItemResource::collection($orderItem);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "item_id"=>"required",
            "quantity"=>"required",
            "order_id"=>"required",
        ]);

        if($validator->fails()){
            return response($validator->errors()->all(), 422);
        }
        $orderItem = OrderItem::create($request->all());
        return new OrderItemResource ($orderItem);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        return new OrderItemResource($orderItem) ;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $orderItem->update($request->all());
        return new OrderItemResource ($orderItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response("Deleted", 204);
    }
}
