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
		];

		foreach ($permissions as $permission) {
			try {
				$permission = Permission::make([
					'name' => $permission['name'],
					'color' => $permission['color'],
					'description' => $permission['description'],
				]);
				$permission->saveOrFail();
			} catch (\Exception $e) {
				// Do nothing
			}
		}
	}
}
