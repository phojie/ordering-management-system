<?php

declare(strict_types=1);

use App\Http\Controllers\Customer\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        // index
        Route::get('/', 'index')->name('categories.index');

        // show
        Route::get('/{slug}', 'show')->name('categories.show');
    });
});
