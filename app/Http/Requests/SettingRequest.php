<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
      $rules = [
        'username' => ['required', 'unique:users,username,' . auth()->id()],
        'firstName' => ['required'],
        'lastName' => ['required'],
        'email' => ['required', 'email', 'unique:users,email,' . auth()->id()],
      ];

      return $rules;
    }
}
