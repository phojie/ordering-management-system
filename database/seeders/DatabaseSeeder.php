<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->call([
            // create permissions
            PermissionSeeder::class,

            // create roles
            RoleSeeder::class,

            // generate default users
            UserSeeder::class,

            // generate admin user
            AdminSeeder::class,

            // generate categories
            CategorySeeder::class,

            // generate products
            ProductSeeder::class,

            // generate variants
            VariantSeeder::class,
        ]);
    }
}
