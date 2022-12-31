<?php

use App\Http\Controllers\Customer\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
	Route::controller(CategoryController::class)->group(function () {
    // show
    Route::get('/{slug}', 'show')->name('categories.show');
	});
});
