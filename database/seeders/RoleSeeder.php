<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
	public function run()
	{
		$roles = [
			'Super Admin',
			'Customer',
			'Admin',
		];

		foreach ($roles as $role) {
			try {
				$role = Role::create(['name' => $role]);
			} catch (\Exception $e) {
				// Do nothing
			}
		}
	}
}
