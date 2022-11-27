<?php

use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {
	Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

	Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
});
