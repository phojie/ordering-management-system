<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name');
            $table->string('color')->nullable();
            $table->string('status')->default('active');

            $table->integer('stock')->default(0);

            $table->float('price')->default(0);

            $table->foreignUuid('item_id')->constrained('items')->cascadeOnDelete();

            $table->timestamps();
        });
    }
};