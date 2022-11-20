<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
	public function definition(): array
	{
		return [
			'username' => fake()->username(),
			'email' => fake()->unique()->safeEmail(),
			'first_name' => fake()->firstName(),
			'middle_name' => fake()->optional()->firstName(),
			'last_name' => fake()->lastName(),
			'email_verified_at' => now(),
			'password' => bcrypt('password'), // password
			'remember_token' => Str::random(10),
			'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
		];
	}

	public function unverified(): static
	{
		return $this->state(fn (array $attributes) => [
			'email_verified_at' => null,
		]);
	}

  public function configure(): static
  {
  	return $this->afterCreating(function (User $user) {
  		$user->assignRole('customer');
  	});
  }
}
