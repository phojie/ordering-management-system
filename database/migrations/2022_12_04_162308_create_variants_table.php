<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('color')->nullable();

            $table->integer('stock')->default(0);

            $table->float('price', 2)->default(0);

            $table->foreignUuid('product_id')->constrained('products')->cascadeOnDelete();

            $table->timestamps();
        });
    }
};
