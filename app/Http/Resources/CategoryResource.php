<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
	public function toArray($request): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'description' => $this->description,
			'status' => $this->status,
			'createdAt' => $this->created_at,
			'updatedAt' => $this->updated_at,
		];
	}
}
