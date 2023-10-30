<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\OrderItem;
use App\Models\OrderItemAddition;
use Illuminate\Support\Collection;
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
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            "items" => ["required"],
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        $newOrder = [
            "user_id" => $user->id,
            "items" => $request->all()
        ];

        // Get order row if exit for the same user
        $order = Order::where("user_id", $user->id)
            ->where("status", "cart")->first();

        if ($order) {
            // if exist
            $this->storeItems($request->items, $order->id);
            return response()->json([
                "data" => new OrderResource($order),
                'status' => 'success',
                'message' => 'Order created successfully'
            ], 201);
        } else {
            // if not exist --> it will create a new order with status cart
            $order = Order::create($newOrder);
            $this->storeItems($request->items, $order->id);
            return response()->json([
                "data" => new OrderResource($order),
                'status' => 'success',
                'message' => 'Order created successfully'
            ], 201);
        }
    }

    public function storeItems($items, $order_id)
    {
        foreach ($items as $item) {
            $orderItem = OrderItem::where("order_id", $order_id)->where("item_id", $item['item_id'])->first();
            
            if ($orderItem) {
                $orderItemAdditions = OrderItemAddition::where("order_item_id", $orderItem->id)->orderBy("addition_id")->get('addition_id')->toArray();
                $sortedAdditions =$this->sortArray($item['additions']);
                $isEqual = $this->checkOrderItemAdditionEquality($orderItemAdditions, $sortedAdditions);
                if ($isEqual) {
                    // if the order item additions is stored before
                    $orderItem->quantity = ++$orderItem->quantity;
                    $orderItem->save();
                } else {
                    $this->storeNewOrderItem($order_id, $item);
                }
            } else {
                $this->storeNewOrderItem($order_id, $item);
            }
        }
    }

    public function sortArray($array)
    {
        $collection = Collection::make($array);
        $sorted = $collection->sortBy('addition_id')->values()->all();
        return $sorted;
    }

    public function checkOrderItemAdditionEquality($array1, $array2)
    {
        if (count($array1) == count($array2)) {
            for ($i = 0; $i < count($array1); $i++) {
                if ($array1[$i] != $array2[$i]) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }

    public function storeNewOrderItem($order_id, $item)
    {
        $orderItem = OrderItem::create([
            'order_id' => $order_id,
            'item_id' => $item['item_id'],
            'quantity' => $item['quantity'],
        ]);

        $this->storeItemAdditions($item['additions'], $orderItem->id);
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
