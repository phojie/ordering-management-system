<?php

declare(strict_types=1);

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
            'name' => $name = $this->generateRandomProduct(),
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

  public function generateRandomProduct(): string
  {
      $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));

      $category1 = $this->faker->foodName();      // A random Food Name
      $category2 = $this->faker->beverageName();  // A random Beverage Name
      $category3 = $this->faker->dairyName();     // A random Dairy Name
      $category4 = $this->faker->vegetableName(); // A random Vegetable Name
      $category5 = $this->faker->fruitName();     // A random Fruit Name
      $category6 = $this->faker->meatName();      // A random Meat Name
      $category7 = $this->faker->sauceName();     // A random Sauce Name

      $categories = [$category1, $category2, $category3, $category4, $category5, $category6, $category7];

      $randomCategory = $categories[array_rand($categories)];

      // while product name is already in the database, generate a new one
      while (Product::where('name', $randomCategory)->exists()) {
          $randomCategory = $categories[array_rand($categories)];
      }

      return $randomCategory;
  }
}
