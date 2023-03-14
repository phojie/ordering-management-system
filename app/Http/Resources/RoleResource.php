<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'color' => $this->color,
            'createdAt' => $this->created_at,
            'deletedAt' => $this->deleted_at,
            'status' => $this->status,

            // relationships
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),

            // optional
            'permissionsCount' => $this->whenNotNull($this->permissions_count),
        ];
    }
}
