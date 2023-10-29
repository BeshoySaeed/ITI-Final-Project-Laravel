<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class userFavourite extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);


        $item = new AdditionResource($this->item);

        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "item_id" => $this->item_id,
            "item" => $item
        ];
    }
}
