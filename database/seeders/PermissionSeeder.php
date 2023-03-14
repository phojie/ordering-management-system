<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            // user
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

            // role
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
            ],

            // category
            [
                'name' => 'category-list',
                'description' => 'List all categories',
            ],
            [
                'name' => 'category-create',
                'description' => 'Create category',
            ],
            [
                'name' => 'category-read',
                'description' => 'Read category',
            ],
            [
                'name' => 'category-update',
                'description' => 'Update category',
            ],
            [
                'name' => 'category-delete',
                'description' => 'Delete category',
            ],

            // product
            [
                'name' => 'product-list',
                'description' => 'List all products',
            ],
            [
                'name' => 'product-create',
                'description' => 'Create product',
            ],
            [
                'name' => 'product-read',
                'description' => 'Read product',
            ],
            [
                'name' => 'product-update',
                'description' => 'Update product',
            ],
            [
                'name' => 'product-delete',
                'description' => 'Delete product',
            ],

            // order
            [
                'name' => 'order-list',
                'description' => 'List all orders',
            ],
            [
                'name' => 'order-create',
                'description' => 'Create order',
            ],
            [
                'name' => 'order-read',
                'description' => 'Read order',
            ],
            [
                'name' => 'order-update',
                'description' => 'Update order',
            ],
            [
                'name' => 'order-delete',
                'description' => 'Delete order',
            ],
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
