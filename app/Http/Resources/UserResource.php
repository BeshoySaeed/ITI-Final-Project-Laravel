<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources;


class UserResource extends JsonResource
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
            "first_name"=>$this->first_name,
            'last_name'=>$this->last_name,
            'role_id'=>$this->role_id,
            'email'=>$this->email,
            'password'=>$this->password,
            'balance'=>$this->balance,
        ];
    }
}
