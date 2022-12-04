<?php

use App\Http\Controllers\Components\CategoryController;
use App\Http\Controllers\Components\ItemController;
use App\Http\Controllers\Components\PermissionController;
use App\Http\Controllers\Components\RoleController;
use App\Http\Controllers\Components\TemporaryFileController;
use App\Http\Controllers\Components\UserController;

Route::prefix('components')->middleware('auth')->group(function () {
	// roles
	Route::get('roles', [RoleController::class, 'index'])->name('components.roles');
	Route::get('roles/{id}', [RoleController::class, 'show'])->name('components.roles.show');

	// permissions
	Route::get('permissions', [PermissionController::class, 'index'])->name('components.permissions');

	// temporary-files
	Route::post('temporary-file', [TemporaryFileController::class, 'store'])->name('components.temporary-file.store');
	Route::delete('temporary-file/{folder}', [TemporaryFileController::class, 'destroy'])->name('components.temporary-file.destroy');

	// users
	Route::get('users/{id}', [UserController::class, 'show'])->name('components.users.show');

	// categories
	Route::get('categories/{id}', [CategoryController::class, 'show'])->name('components.categories.show');

	// items
	Route::get('items/{id}', [ItemController::class, 'show'])->name('components.items.show');
});
