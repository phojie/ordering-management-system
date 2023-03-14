<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('temporary_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('folder');
            $table->string('filename');
            $table->timestamps();
        });
    }
};
