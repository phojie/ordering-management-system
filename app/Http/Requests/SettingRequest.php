<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
	public function rules(): array
	{
		$rules = [];

		// if function name is updateGeneral
		if ($this->route()->getActionMethod() === 'updateGeneral') {
			$rules['username'] = ['required', 'unique:users,username,'.auth()->id()];
			$rules['firstName'] = ['required'];
			$rules['lastName'] = ['required'];
			$rules['email'] = ['required', 'email', 'unique:users,email,'.auth()->id()];
		}

		// if function name is updatePassword
		if ($this->route()->getActionMethod() === 'updatePassword') {
			$rules['currentPassword'] = ['required', 'current_password'];
			$rules['newPassword'] = ['required', 'min:6'];
			$rules['confirmPassword'] = ['required', 'same:newPassword'];
		}

		return $rules;
	}
}
