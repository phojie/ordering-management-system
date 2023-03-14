<?php

declare(strict_types=1);

use App\Http\Controllers\Customer\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/settings', [SettingController::class, 'index'])->name('customer.settings.index');

Route::put('/settings/general', [SettingController::class, 'updateGeneral'])->name('customer.settings.update.general');

Route::put('/settings/password', [SettingController::class, 'updatePassword'])->name('customer.settings.update.password');
