<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
      'image' => $this->image,

			// relationships
			'variants' => VariantResource::collection($this->whenLoaded('variants')),
      'categories' => CategoryResource::collection($this->whenLoaded('categories')),
		];
	}
}
