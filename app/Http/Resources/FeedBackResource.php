<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedBackResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = new UserResource($this->user);
        
        return [
            "id" => $this->id,
            "rate_value" => $this->rate_value,
            "rate_comment" => $this->rate_comment,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "user_first_name" => $user ? $user->first_name : null,
            "user_last_name" => $user ? $user->last_name : null
        ];
    }
}
