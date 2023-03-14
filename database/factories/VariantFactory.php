<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Variant>
 */
class VariantFactory extends Factory
{
    protected $model = Variant::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'stock' => $this->faker->randomNumber(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'product_id' => Product::inRandomOrder()->first()->id,
        ];
    }
}
