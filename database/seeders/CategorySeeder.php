<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
      \App\Models\Category::factory()->count(10)->create();
    }
}
