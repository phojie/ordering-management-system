<?php

namespace Database\Factories;

use App\Models\Item;
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
			'item_id' => Item::inRandomOrder()->first()->id,
		];
	}
}
