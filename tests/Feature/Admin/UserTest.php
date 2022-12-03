<?php

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

		$this->seed();

		$this->user = User::where('email', 'j@y.com')->first();

		$this->response = $this->actingAs($this->user);
	}

	public function test_admin_users_can_render_page()
	{
		$this->response = $this->get('/admin/users');

		$this->response->assertStatus(200);
	}

	public function test_admin_users_can_store_user()
	{
		$response = $this->response;

		// post user
		$response = $this->post('/admin/users', [
			'username' => 'test',
			'email' => 'test@y.com',
			'firstName' => 'test',
			'lastName' => 'test',
			'password' => 'password',
		]);

		\Log::info($response->getContent());

		$response->assertStatus(200);
	}

	public function test_admin_users_can_update_user()
	{
		$user = $this->user;

		// post user
		$response = $this->put("/admin/users/$user->id", [
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
		$user = $this->user;
		// post user
		$response = $this->delete("/admin/users/$user->id");

		$response->assertStatus(302);
	}

	public function test_admin_users_can_restore_user()
	{
		$user = $this->user;
		// post user
		$response = $this->put("/admin/users/$user->id/restore");

		$response->assertStatus(302);
	}

	public function test_admin_users_can_delete_multiple_users()
	{
		$user = $this->user;
		$users = User::factory()->count(3)->create()->pluck('id')->toArray();

		$response = $this->actingAs($user);

		$response = $this->delete('/admin/users', [
			'ids' => $users,
		]);

		$response->assertStatus(302);
	}

	public function test_admin_users_can_restore_multiple_users()
	{
		$users = User::factory()->count(3)->create()->pluck('id')->toArray();

		$response = $this->delete('/admin/users', [
			'ids' => $users,
		]);

		$response = $this->put('/admin/users/restore', [
			'ids' => $users,
		]);

		$response->assertStatus(302);
	}
}
