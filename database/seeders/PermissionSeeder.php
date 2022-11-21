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
			[
        'name' => 'user-create',
        'color' => 'green',
        'description' => 'Create user'
      ],
      [
        'name' => 'user-read',
        'color' => 'blue',
        'description' => 'Read user'
      ],
      [
        'name' => 'user-update',
        'color' => 'yellow',
        'description' => 'Update user'
      ],
      [
        'name' => 'user-delete',
        'color' => 'red',
        'description' => 'Delete user'
      ],
		];

		foreach ($permissions as $permission) {
			// $permission = Permission::make(['name' => $permission]);
			// $permission->saveOrFail();
		}
	}
}
