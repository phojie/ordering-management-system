<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Admin role
        User::factory(1)->create([
            'username' => 'admin',
            'email' => 'admin@test.com',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'password' => bcrypt('password'),
        ]);

        // assign super admin
        $admin = User::where('username', 'admin')->first();
        $admin->assignRole(['Admin', 'Super Admin', 'Customer']);
    }
}
