<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('name')->unique();
            $table->string('color')->nullable();
            $table->string('description')->nullable();
            $table->string('slug')->unique();

            $table->softDeletes();
            $table->timestamps();
        });
    }
};
