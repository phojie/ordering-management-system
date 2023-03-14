<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'address' => $this->address,
            'city' => $this->city,
            'province' => $this->province,
            'postalCode' => $this->postal_code,
            'country' => $this->country,
            'fullAddress' => $this->full_address,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
