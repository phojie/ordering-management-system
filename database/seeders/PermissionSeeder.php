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
        'name' => 'user-list',
        'description' => 'List all users',
      ],
			[
				'name' => 'user-create',
				'description' => 'Create user',
			],
			[
				'name' => 'user-read',
				'description' => 'Read user',
			],
			[
				'name' => 'user-update',
				'description' => 'Update user',
			],
			[
				'name' => 'user-delete',
				'description' => 'Delete user',
			],
      [
        'name' => 'role-list',
        'description' => 'List all roles',
      ],
      [
        'name' => 'role-create',
        'description' => 'Create role',
      ],
      [
        'name' => 'role-read',
        'description' => 'Read role',
      ],
      [
        'name' => 'role-update',
        'description' => 'Update role',
      ],
      [
        'name' => 'role-delete',
        'description' => 'Delete role',
      ]
		];

		foreach ($permissions as $permission) {
			try {
				$permission = Permission::make([
					'name' => $permission['name'],
					'description' => $permission['description'],
				]);
				$permission->saveOrFail();
			} catch (\Exception $e) {
				// Do nothing
			}
		}
	}
}
