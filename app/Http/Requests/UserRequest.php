<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
	public function authorize() : bool
	{
		return true;
	}

   public function rules() : array
   {
   	$rules = [
      'username' => ['required', 'unique:users'],
      // 'roles' => ['required', 'array', 'min:1'],
      'password' => ['required', 'min:6'],
      'firstName' => ['required'],
      'lastName' => ['required'],
      'email' => ['required', 'email', 'unique:users'],
    ];

   	if ($this->getMethod() == 'PUT') {
   		// unique except present present username, detect by id
   		$rules['username'][1] = ['unique:users,username,'.request()->id];
   		$rules['password'] = [];
   		$rules['email'] = ['unique:users,email,'.request()->id];
   	}

   	return $rules;
   }
}
