<?php

use App\Http\Controllers\Next\Auth\LoginController;
use App\Http\Controllers\Next\BoardController;
use App\Http\Controllers\Next\HomeController;
use App\Http\Controllers\Next\ThreadController;
use App\Http\Controllers\Next\UserController;
use App\Http\Controllers\Next\UserSettingsController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'next');

Route::group(['prefix' => 'next', 'as' => 'next.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/b', fn () => redirect()->route('next.boards.show', 'all'))->name('boards.index');
    Route::get('/b/{board_slug}', [BoardController::class, 'show'])->name('boards.show');
    Route::get('/b/{board_slug}/{thread_id}/{thread_slug?}', [BoardController::class, 'show'])->name('threads.show');

    Route::get('/u/{name}', [UserController::class, 'show'])->name('users.show');

    // Route::get('/threads', [threadController::class, 'index'])->name('threads.index');
    // Route::get('/threads/{threadId}/{slug?}', [threadController::class, 'index'])->name('threads.show');

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'submit']);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        Route::get('/settings', fn () => redirect()->route('next.settings.profile'))->name('settings');
        Route::get('/settings/profile', [UserSettingsController::class, 'profile'])->name('settings.profile');
        Route::post('/settings/profile', [UserSettingsController::class, 'submitProfile']);
        Route::get('/settings/account', [UserSettingsController::class, 'account'])->name('settings.account');
        Route::post('/settings/account', [UserSettingsController::class, 'submitAccount']);
        Route::get('/settings/security', [UserSettingsController::class, 'security'])->name('settings.security');
        Route::post('/settings/security', [UserSettingsController::class, 'submitSecurity']);
        Route::post('/settings/security/2fa/enable', [UserSettingsController::class, 'enable2FA'])->name('settings.security.2fa.enable');
        Route::post('/settings/security/2fa/disable', [UserSettingsController::class, 'disable2FA'])->name('settings.security.2fa.disable');

        Route::get('/settings/notifications', [UserSettingsController::class, 'notifications'])->name('settings.notifications');
        Route::post('/settings/notifications', [UserSettingsController::class, 'submitNotifications']);
        Route::get('/settings/design', [UserSettingsController::class, 'design'])->name('settings.design');
        // Route::post('/settings/design', [UserSettingsController::class, 'submitDesign']);
    });
});
