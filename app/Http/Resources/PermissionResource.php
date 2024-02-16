<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $permission = explode('-', $this->name);
        return [
            'id' => $this->id,
            'page' => ucfirst($permission[0]),
            'action' => ucfirst($permission[1]),
            'guard_name' => $this->guard_name,
            'assigned_to' => $this->roles()->pluck('name')->toArray(),
            'created_at' => $this->created_at->format('d M Y, g:i A'),
        ];
    }
}
