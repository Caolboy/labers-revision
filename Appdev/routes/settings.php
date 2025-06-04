<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\UserPasswordController;
use App\Http\Controllers\Settings\UserProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('settings/userprofile', [UserProfileController::class, 'edit'])->name('userprofile.edit');
    Route::patch('settings/userprofile', [UserProfileController::class, 'update'])->name('userprofile.update');
    Route::delete('settings/userprofile', [UserProfileController::class, 'destroy'])->name('userprofile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('settings/userpassword', [UserPasswordController::class, 'edit'])->name('userpassword.edit');
    Route::put('settings/userpassword', [UserPasswordController::class, 'update'])->name('userpassword.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance');
    Route::get('settings/userappearance', function () {
        return Inertia::render('settings/UserAppearance');
    })->name('userappearance');
});
