<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('user_id')
                      ->constrained('users')
                      ->onDelete('cascade');

            $table->foreignUuid('variant_id')
                            ->constrained('variants')
                            ->onDelete('cascade');

            $table->foreignUuid('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->integer('quantity')->unsigned();
            $table->timestamps();
        });
    }
};
