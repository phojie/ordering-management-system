<?php

use App\Http\Controllers\Components\RoleController;

Route::prefix('components')->middleware('auth')->group(function () {
  // roles auth
  Route::get('roles', [RoleController::class, 'get'])->name('components.roles');
});
