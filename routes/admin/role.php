<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles')->group(function () {
    Route::controller(RoleController::class)->group(function () {
        // delete
        Route::delete('/{role}', 'destroy')->name('admin.roles.destroy');
        Route::delete('/', 'destroyMultiple')->name('admin.roles.destroy-multiple');

        // restore
        Route::put('/{role}/restore', 'restore')->name('admin.roles.restore')->withTrashed();
        Route::put('/restore', 'restoreMultiple')->name('admin.roles.restore-multiple');

        // index
        Route::get('/', 'index')->name('admin.roles.index');

        // create
        Route::post('/', 'store')->name('admin.roles.store');

        // update
        Route::put('/{role}', 'update')->name('admin.roles.update');
    });
});
