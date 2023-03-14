<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public $response;

    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(['PermissionSeeder', 'RoleSeeder', 'UserSeeder', 'AdminSeeder']);

        // get admin user from roles tabless
        $this->user = User::withTrashed()->role('Super Admin')->first();

        // login as admin user

        $this->response = $this->actingAs($this->user);
    }

    public function test_admin_users_can_render_page()
    {
        $response = $this->response;

        $response = $this->get(route('admin.users.index'));

        $response->assertStatus(200);
    }

    public function test_admin_users_can_store_user()
    {
        $response = $this->response;

        // post user
        $response = $this->post(route('admin.users.store'), [
            'username' => 'test',
            'email' => 'test@y.com',
            'firstName' => 'test',
            'lastName' => 'test',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_admin_users_can_update_user()
    {
        $response = $this->response;

        $user = $this->user;

        // post user
        $response = $this->put(route('admin.users.update', $user->id), [
            'username' => 'test2',
            'email' => 'test@y.com',
            'firstName' => 'test',
            'lastName' => 'test',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
    }

    public function test_admin_users_can_delete_user()
    {
        $response = $this->response;
        $user = $this->user;
        // delete user
        $response = $this->delete(route('admin.users.destroy', $user->id));

        $response->assertStatus(302);
    }

    public function test_admin_users_can_restore_user()
    {
        $response = $this->response;
        $user = $this->user;

        // delete user
        $response = $this->delete(route('admin.users.destroy', $user->id));

        // restore user
        $response = $this->put(route('admin.users.restore', $user->id));

        $response->assertStatus(302);
    }

    public function test_admin_users_can_delete_multiple_users()
    {
        $response = $this->response;

        $user = $this->user;

        $users = User::factory()->count(3)->create()->pluck('id')->toArray();

        $response = $this->actingAs($user);

        $response = $this->delete(route('admin.users.destroy-multiple', [
            'ids' => $users,
        ]));

        $response->assertStatus(302);
    }

    public function test_admin_users_can_restore_multiple_users()
    {
        $response = $this->response;

        $users = User::factory()->count(3)->create()->pluck('id')->toArray();

        $response = $this->delete(route('admin.users.destroy-multiple', [
            'ids' => $users,
        ]));

        $response = $this->put(route('admin.users.restore-multiple', [
            'ids' => $users,
        ]));

        $response->assertStatus(302);
    }
}
