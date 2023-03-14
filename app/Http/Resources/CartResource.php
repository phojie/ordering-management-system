<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'variantId' => $this->variant_id,
            'quantity' => $this->quantity,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            // relations
            'variant' => new VariantResource($this->whenLoaded('variant')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
