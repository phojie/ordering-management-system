<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('order_variants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->default('pending');

            $table->foreignUuid('order_id')
            ->constrained('orders')
            ->onDelete('cascade');

            $table->foreignUuid('variant_id')
            ->constrained('variants')
            ->onDelete('cascade');

            $table->foreignUuid('product_id')
            ->constrained('products')
            ->onDelete('cascade');

            $table->integer('quantity');
            $table->float('price', 2);
            $table->float('total', 2);

            $table->timestamps();
        });
    }

  public function down()
  {
      Schema::dropIfExists('order_variants');
  }
};
