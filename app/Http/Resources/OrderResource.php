<?php

namespace App\Http\Resources;

use App\Models\UserPhone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $user = new UserResource($this->user);
        $items = ItemResource::collection($this->orderItems->map(function ($orderItem) {
            return $orderItem->item;
        }));

        return [
            "id" => $this->id,
            "completed" => $this->completed,
            "note" => $this->note,
            "payment_method" => $this->payment_method,
            "discount_code" => $this->discount_code,
            "confirm_instructions" => $this->confirm_instructions,
            "street"  => $this->street,
            "area" => $this->area,
            "city" => $this->city,
            "building_name" => $this->building_name,
            "floor_number" => $this->floor_number,
            "flat_number" => $this->flat_number,
            "GPS_location" => $this->GPS_location,
             "created_at" => $this->created_at,
             "user" => $user,
              "items" => $items,
        ];

}
}
