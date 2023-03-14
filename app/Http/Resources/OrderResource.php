<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'orderNumber' => $this->order_number,
            'email' => $this->email,
            'phone' => $this->phone,

            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postalCode' => $this->postal_code,
            'status' => $this->status,

            'totalAmount' => $this->total_amount,
            'taxesAmount' => $this->taxes_amount,
            'shippingAmount' => $this->shipping_amount,

            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            // relationships
            'orderVariants' => OrderVariantResource::collection($this->whenLoaded('orderVariants')),
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
