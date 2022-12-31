<?php

use App\Http\Controllers\Customer\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
	Route::controller(ProductController::class)->group(function () {
    // show
    Route::get('/{slug}', 'show')->name('products.show');
	});
});
