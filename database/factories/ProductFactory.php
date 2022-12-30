<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
          'name' => $name = $this->faker->unique()->words(3, true),
          'slug' => Str::slug($name),
          'description' => $this->faker->sentence,
          'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
