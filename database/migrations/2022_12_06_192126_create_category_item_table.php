<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('category_item', function (Blueprint $table) {
			$table->foreignUuid('category_id')
			->constrained('categories')
			->onDelete('cascade');

			$table->foreignUuid('item_id')
			->constrained('items')
			->onDelete('cascade');

			$table->timestamps();
		});
	}
};
