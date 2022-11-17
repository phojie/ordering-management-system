<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {
	Route::controller(UserController::class)->group(function () {
    // delete
		Route::delete('/users/{user}', 'destroy')->name('users.destroy');
		Route::delete('/users', 'destroyMultiple')->name('users.destroy-multiple');

    // restore
		Route::put('/users/{user}/restore', 'restore')->name('users.restore')->withTrashed();
		Route::put('/users/restore', 'restoreMultiple')->name('users.restore-multiple');

    // index
		Route::get('/users', 'index')->name('users.index');

    // create
		Route::post('/users', 'store')->name('users.store');

    // Route::get('/users/{user}', 'show')->name('users.show');

    // update
		Route::put('/users/{user}', 'update')->name('users.update');
	});
});
