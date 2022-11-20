<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
	public function run()
	{
		$roles = [
			'super admin',
			'customer',
		];

		foreach ($roles as $role) {
			Role::create(['name' => $role]);
		}
	}
}
