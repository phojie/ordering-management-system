<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $name = $this->faker->unique()->words(1, true),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
