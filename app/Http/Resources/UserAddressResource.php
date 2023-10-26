<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources;
use App\Http\Resources\UserResource;



class UserAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "user_id"=>$this->user_id,
            "street"=>$this->street,
            "area"=>$this->area,
            "city"=>$this->city,
            "building_name"=>$this->building_name,
            "floor_number"=>$this->floor_number,
            "flat_number"=>$this->flat_number,
            "gps_location"=>$this->gps_location,
    
        ];
    }
}
