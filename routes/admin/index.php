<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Admin/Index');
});

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

Route::put('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.update.general');

Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.update.password');

Route::get('/admin/menus', function () {
	return Inertia::render('Admin/Menus', [
		'menus' => [],
	]);
});
