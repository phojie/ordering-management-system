<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run(): void
	{
		// generate admin account
		$this->call(AdminSeeder::class);

		// generate 100 users
		$this->call(UserSeeder::class);
	}
}
