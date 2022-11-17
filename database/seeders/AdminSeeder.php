<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
	public function run(): void
	{
		User::factory(1)->create([
			'username' => 'admin',
			'email' => 'jie@y.com',
			'first_name' => 'Admin',
			'last_name' => 'User',
			'password' => bcrypt('jiejie'),
		]);
	}
}
