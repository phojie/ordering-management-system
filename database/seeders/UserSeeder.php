<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	public function run(): void
	{
		// Create a user and assign as a Customer role
		User::factory(10)->create();

		// Admin role
		User::factory(1)->create([
			'username' => 'admin',
			'email' => 'j@y.com',
			'first_name' => 'Admin',
			'last_name' => 'User',
			'password' => bcrypt('password'),
		]);

		// assign super admin
		$admin = User::where('username', 'admin')->first();
		$admin->assignRole('super-admin');
	}
}
