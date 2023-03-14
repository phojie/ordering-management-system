<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        // delete
        Route::delete('/{product}', 'destroy')->name('admin.products.destroy');
        Route::delete('/', 'destroyMultiple')->name('admin.products.destroy-multiple');

        // restore
        Route::put('/{product}/restore', 'restore')->name('admin.products.restore')->withTrashed();
        Route::put('/restore', 'restoreMultiple')->name('admin.products.restore-multiple');

        // index
        Route::get('/', 'index')->name('admin.products.index');

        // create
        Route::post('/', 'store')->name('admin.products.store');

        // update
        Route::put('/{product}', 'update')->name('admin.products.update');
    });
});
