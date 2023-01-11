<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
	/**
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required|numeric|digits:12|starts_with:09',
			'address' => 'required',
			'city' => 'required',
			'province' => 'required',
			'postalCode' => 'required',
			// 'paymentMethod' => 'required',
			'orderVariants' => 'required|array',
		];
	}
}
