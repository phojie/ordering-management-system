<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
	Route::controller(UserController::class)->group(function () {
		// delete
		Route::delete('/{user}', 'destroy')->name('users.destroy');
		Route::delete('/', 'destroyMultiple')->name('users.destroy-multiple');

		// restore
		Route::put('/{user}/restore', 'restore')->name('users.restore')->withTrashed();
		Route::put('/restore', 'restoreMultiple')->name('users.restore-multiple');

		// index
		Route::get('/', 'index')->name('users.index');

		// create
		Route::post('/', 'store')->name('users.store');

		// Route::get('/{user}', 'show')->name('users.show');

		// update
		Route::put('/{user}', 'update')->name('users.update');
	});
});
