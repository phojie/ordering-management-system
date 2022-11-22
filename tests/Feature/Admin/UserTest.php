<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
	use RefreshDatabase;

	public function test_admin_users_can_render_page()
	{
		$user = User::factory()->create();

		$response = $this->actingAs($user);

		$response = $this->get('/admin/users');

		$response->assertStatus(200);
	}

  public function test_admin_users_can_create_user()
  {
  	$user = User::factory()->create();

  	$response = $this->actingAs($user);

  	// post user
  	$response = $this->post('/admin/users', [
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
  	$user = User::factory()->create();

  	$response = $this->actingAs($user);

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
  	$user = User::factory()->create();

  	$response = $this->actingAs($user);

  	// post user
  	$response = $this->delete("/admin/users/$user->id");

  	$response->assertStatus(302);
  }

  public function test_admin_users_can_restore_user()
  {
  	$user = User::factory()->create();

  	$response = $this->actingAs($user);

  	// post user
  	$response = $this->put("/admin/users/$user->id/restore");

  	$response->assertStatus(302);
  }

  public function test_admin_users_can_delete_multiple_users()
  {
  	$user = User::factory()->create();
  	$users = User::factory()->count(3)->create()->pluck('id');

  	$response = $this->actingAs($user);

  	$response = $this->delete('/admin/users', [
  		'ids' => $users,
  	]);

  	$response->assertStatus(302);
  }

  public function test_admin_users_can_restore_multiple_users()
  {
  	$user = User::factory()->create();
  	$users = User::factory()->count(3)->create()->pluck('id');

  	$response = $this->actingAs($user);

  	$response = $this->delete('/admin/users', [
  		'ids' => $users,
  	]);

  	$response = $this->put('/admin/users/restore', [
  		'ids' => $users,
  	]);

  	$response->assertStatus(302);
  }
}
