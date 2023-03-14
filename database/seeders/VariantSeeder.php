<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Variant;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    public function run()
    {
        Variant::factory(15)->create();
    }
}
