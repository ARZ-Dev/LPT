<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->id,
            'full_name' => $this->first_name." ".$this->last_name,
            'role' => $this->roles[0]->name ?? 'No Role',
            'role_id' => $this->roles[0]->id ?? 0,
            'username' => $this->username,
            'email' => $this->email,
  
            'phone' => $this->phone,
        ];
    }
}
