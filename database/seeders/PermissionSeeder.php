<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
	public function run()
	{
		// Create permissions
		$permissions = [
			'user-list',
			'user-create',
			'user-edit',
			'user-delete',
			'role-list',
			'role-create',
			'role-edit',
			'role-delete',
			'permission-list',
			'permission-create',
			'permission-edit',
			'permission-delete',
		];

		foreach ($permissions as $permission) {
			$permission = Permission::make(['name' => $permission]);
			$permission->saveOrFail();
		}
	}
}
