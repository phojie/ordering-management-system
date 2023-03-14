<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderVariantResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'variantId' => $this->variant_id,
            'productId' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->total,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            'variant' => new VariantResource($this->whenLoaded('variant')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
