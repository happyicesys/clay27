<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\TwoFactorAuthenticationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('user-password.edit');

    Route::put('settings/password', [PasswordController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('user-password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance.edit');

    Route::get('settings/two-factor', [TwoFactorAuthenticationController::class, 'show'])
        ->name('two-factor.show');

    Route::get('settings/two-factor/qr-code', [Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController::class, 'show'])
        ->name('two-factor.qr-code');

    Route::get('settings/two-factor/secret-key', [Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController::class, 'show'])
        ->name('two-factor.secret-key');

    Route::get('settings/two-factor/recovery-codes', [Laravel\Fortify\Http\Controllers\RecoveryCodeController::class, 'index'])
        ->name('two-factor.recovery-codes');

    Route::post('settings/two-factor/recovery-codes', [Laravel\Fortify\Http\Controllers\RecoveryCodeController::class, 'store'])
        ->name('two-factor.regenerate-recovery-codes');

    Route::post('settings/two-factor/confirm', [Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController::class, 'store'])
        ->name('two-factor.confirm');

    Route::post('settings/two-factor', [Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::class, 'store'])
        ->name('two-factor.enable');

    Route::delete('settings/two-factor', [Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController::class, 'destroy'])
        ->name('two-factor.disable');
});
