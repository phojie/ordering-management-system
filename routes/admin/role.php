<?php

use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles')->group(function () {
	Route::controller(RoleController::class)->group(function () {
		// delete
		Route::delete('/{role}', 'destroy')->name('roles.destroy');
		Route::delete('/', 'destroyMultiple')->name('roles.destroy-multiple');

		// restore
		Route::put('/{role}/restore', 'restore')->name('roles.restore')->withTrashed();
		Route::put('/restore', 'restoreMultiple')->name('roles.restore-multiple');

		// index
		Route::get('/', 'index')->name('roles.index');

		// create
		Route::post('/', 'store')->name('roles.store');

		// update
		Route::put('/{role}', 'update')->name('roles.update');
	});
});
