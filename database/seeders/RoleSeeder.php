<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'Super Admin',
            'Admin',

            'Customer',

            'Category Manager',
            'Product Manager',
            'Order Manager',
            'User Manager',
            'Role Manager',
            'Delivery Manager',
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
