<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
	public function definition() : array
	{
		return [
			'username' => fake()->username(),
			'email' => fake()->unique()->safeEmail(),
			'first_name' => fake()->firstName(),
			'middle_name' => fake()->optional()->firstName(),
			'last_name' => fake()->lastName(),
			'image_url' =>'https://robohash.org/'.fake()->username().'?set=set3&bgset=bg2&size=400x400',
			'email_verified_at' => now(),
			'password' => bcrypt('password'), // password
			'remember_token' => Str::random(10),
		];
	}

	public function unverified() : static
	{
		return $this->state(fn (array $attributes) => [
			'email_verified_at' => null,
		]);
	}
}
