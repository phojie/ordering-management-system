<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'unique:products'],
            'description' => ['required', 'string', 'max:100'],
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['name'][1] = 'unique:products,name,'.request()->id;
        }

        return $rules;
    }
}
