<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::controller(UserController::class)->group(function () {
        // delete
        Route::delete('/{user}', 'destroy')->name('admin.users.destroy');
        Route::delete('/', 'destroyMultiple')->name('admin.users.destroy-multiple');

        // restore
        Route::put('/{user}/restore', 'restore')->name('admin.users.restore')->withTrashed();
        Route::put('/restore', 'restoreMultiple')->name('admin.users.restore-multiple');

        // index
        Route::get('/', 'index')->name('admin.users.index');

        // create
        Route::post('/', 'store')->name('admin.users.store');

        // Route::get('/{user}', 'show')->name('users.show');

        // update
        Route::put('/{user}', 'update')->name('admin.users.update');
    });
});
