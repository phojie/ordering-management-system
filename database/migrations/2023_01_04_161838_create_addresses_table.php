<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->string('country')->default('Philippines');

            $table->foreignUuid('user_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }
};
