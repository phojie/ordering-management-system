<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignUuid('category_id')
            ->constrained('categories')
            ->onDelete('cascade');

            $table->foreignUuid('product_id')
            ->constrained('products')
            ->onDelete('cascade');

            $table->timestamps();
        });
    }
};
