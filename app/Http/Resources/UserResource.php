<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'firstName' => $this->first_name,
            'middleName' => $this->middle_name,
            'lastName' => $this->last_name,
            'fullName' => $this->full_name,
            'emailVerifiedAt' => $this->email_verified_at,
            'createdAt' => $this->created_at,
            'status' => $this->status,
            'avatar' => $this->avatar,
            'phone' => $this->phone,

            // when address is loaded
            // merge all to single address1, address2, city, state, zip, country
            'address1' => $this->whenLoaded('address', function () {
                return $this->address->address1;
            }),
            'address2' => $this->whenLoaded('address', function () {
                return $this->address->address2;
            }),
            'city' => $this->whenLoaded('address', function () {
                return $this->address->city;
            }),
            'province' => $this->whenLoaded('address', function () {
                return $this->address->province;
            }),
            'postalCode' => $this->whenLoaded('address', function () {
                return $this->address->postal_code;
            }),
            'country' => $this->whenLoaded('address', function () {
                return $this->address->country;
            }),
            'fullAddress' => $this->whenLoaded('address', function () {
                return $this->address->full_address;
            }),

            // relationships
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
        ];
    }
}
