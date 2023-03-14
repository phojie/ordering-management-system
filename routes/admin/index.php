<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [DashboardController::class, 'index'])->name('admin.index');

Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');

Route::put('/settings/general', [SettingController::class, 'updateGeneral'])->name('admin.settings.update.general');

Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('admin.settings.update.password');

Route::get('/admin/menus', function () {
    return Inertia::render('Admin/Menus', [
        'menus' => [],
    ]);
});
