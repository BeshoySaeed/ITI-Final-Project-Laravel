<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\OrderItem;
use App\Models\OrderItemAddition;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware("auth:sanctum");
        $this->middleware("is_admin")->only('index');
    }

    public function index()
    {
        $order = Order::all();
        return OrderResource::collection($order);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "status" => "required",
            "user_id" => ["required", "exists:users,id"],
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        // Get order row if exit for the same user
        $order = Order::where("user_id", $request->user_id)
            ->where("status", "cart")->first();

        if ($order) {
            // if exist
            $this->storeItems($request->items, $order->id);
        } else {
            // if not exist --> it will create a new order with status cart
            $order = Order::create($request->all());
            $this->storeItems($request->items, $order->id);
            return new OrderResource($order);
        }
    }

    public function storeItems($items, $order_id)
    {
        foreach ($items as $item) {
            $orderItem = OrderItem::create([
                'order_id' => $order_id,
                'item_id' => $item['item_id'],
                'quantity' => $item['quantity'],
            ]);

            // dd($orderItem->id);
            
            $this->storeItemAdditions($item['additions'], $orderItem->id);
        }
    }

    public function storeItemAdditions($additions, $order_item_id)
    {
        foreach ($additions as $addition) {
            OrderItemAddition::create([
                'order_item_id' => $order_item_id,
                'addition_id' => $addition['addition_id'],
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->update($request->all());
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response("Deleted", 204);
    }
}
