<?php

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

			// relationships
			'roles' => RoleResource::collection($this->whenLoaded('roles')),
			'addresses' => AddressResource::collection($this->whenLoaded('addresses')),
		];
	}
}
