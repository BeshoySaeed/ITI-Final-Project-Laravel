<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // $itemAdditions = new AdditionResource($this->additions);
        $itemAdditions = AdditionResource::collection($this->itemAdditions->map(function ($itemAddition) {
            return $itemAddition->addition;
        }));


        return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => $this->image,
            "price" => $this->price,
            "description" => $this->description,
            "discount" => $this->discount,
            "active"  => $this->active,
            "category_id" => $this->category_id,
            "itemAdditions" => $itemAdditions
        ];
    }
}
