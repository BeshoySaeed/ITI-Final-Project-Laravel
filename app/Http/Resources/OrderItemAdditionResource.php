<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemAdditionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "order_item_id" => $this->order_item_id,
            "addition_id" => $this->addition_id,
            "addition"  => new AdditionResource($this->addition),
        ];
    }
}
