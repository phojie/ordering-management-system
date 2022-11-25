<?php

namespace App\Http\Controllers\Components;

use App\Models\Role;

class RoleController
{
	public function get()
	{
		// TODO implement searchable and pagination
		$query = Role::get();

		return response()->json($query, 200);
	}
}
