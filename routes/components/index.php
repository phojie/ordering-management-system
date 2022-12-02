<?php

use App\Http\Controllers\Components\PermissionController;
use App\Http\Controllers\Components\RoleController;
use App\Http\Controllers\Components\UploadController;

Route::prefix('components')->middleware('auth')->group(function () {
	// roles
	Route::get('roles', [RoleController::class, 'index'])->name('components.roles');
	Route::get('roles/{id}', [RoleController::class, 'show'])->name('components.roles.show');

	// permissions
	Route::get('permissions', [PermissionController::class, 'index'])->name('components.permissions');

	// upload
	Route::post('upload', [UploadController::class, 'store'])->name('components.upload.store');
});
