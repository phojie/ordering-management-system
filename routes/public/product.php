<?php

declare(strict_types=1);

use App\Http\Controllers\Customer\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        //index
        Route::get('/', 'index')->name('products.index');

        // show
        Route::get('/{slug}', 'show')->name('products.show');
    });
});
