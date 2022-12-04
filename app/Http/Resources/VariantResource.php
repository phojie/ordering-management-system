<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
{
	public function toArray($request): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'status' => $this->status,
			'stock' => $this->stock,
			'price' => $this->price,
      'color' => $this->color,
			'createdAt' => $this->created_at,
			'updatedAt' => $this->updated_at,
		];
	}
}
