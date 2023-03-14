<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('categories')->group(function () {
    Route::controller(CategoryController::class)->group(function () {
        // delete
        Route::delete('/{category}', 'destroy')->name('admin.categories.destroy');
        Route::delete('/', 'destroyMultiple')->name('admin.categories.destroy-multiple');

        // restore
        Route::put('/{category}/restore', 'restore')->name('admin.categories.restore')->withTrashed();
        Route::put('/restore', 'restoreMultiple')->name('admin.categories.restore-multiple');

        // index
        Route::get('/', 'index')->name('admin.categories.index');

        // create
        Route::post('/', 'store')->name('admin.categories.store');

        // update
        Route::put('/{category}', 'update')->name('admin.categories.update');
    });
});
