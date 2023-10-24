<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $branch = new BranchResource($this->branch);

        return [
            "id" => $this->id,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "job_title" => $this->job_title,
            "email" => $this->email,
            "phone" => $this->phone,
            "national_id" => $this->national_id,
            "street" => $this->street,
            "area" => $this->area,
            "city" => $this->city,
            "salary" => $this->salary,
            "joined_at" => $this->joined_at,
            "branchName" => $branch ? $branch->name : null
        ];
    }
}
