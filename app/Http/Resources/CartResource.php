<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
	public function toArray($request): array
	{
		return [
			'id' => $this->id,
			'user_id' => $this->user_id,
			'variant_id' => $this->variant_id,
			'quantity' => $this->quantity,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,

			// relations
			'variant' => new VariantResource($this->whenLoaded('variant')),
			'product' => new ProductResource($this->whenLoaded('product')),
		];
	}
}
