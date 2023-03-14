<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'unique:roles'],
            'description' => ['required', 'string', 'max:100'],
        ];

        if ($this->getMethod() == 'PUT') {
            $rules['name'][1] = 'unique:roles,name,'.request()->id;
        }

        return $rules;
    }
}
