<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
	public function rules(): array
	{
		$rules = [
			'name' => ['required', 'unique:items'],
			'description' => ['required', 'string', 'max:100'],
		];

		if ($this->getMethod() == 'PUT') {
			$rules['name'][1] = 'unique:items,name,'.request()->id;
		}

		return $rules;
	}
}
