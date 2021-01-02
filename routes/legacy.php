<?php

use App\Http\Controllers\Api\EmojiController as ApiEmojiController;
use App\Http\Controllers\Api\threadController as ApithreadController;
use App\Http\Controllers\Api\UsersController as ApiUsersController;
use App\Http\Controllers\Api\WebpushController as ApiWebpushController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivatethreadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Settings\ConnectionsController;
use App\Http\Controllers\threadController;
use App\Http\Controllers\threadPostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'legacy'], function () {
    Route::view('/login', 'unavailable')->name('login');
    Route::view('/logout', 'unavailable')->name('logout');

    Route::get('/', [threadController::class, 'index'])->name('home');

    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'submit']);
    Route::get('/auth/verify_email/{token}', [RegisterController::class, 'verify'])->name('auth.verify_email');

    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset/{token}', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('/d', [threadController::class, 'index'])->name('threads.index');
    Route::get('/d/c/{board}-{slug}', [threadController::class, 'index'])->name('threads.boards.index');

    Route::get('/search', [SearchController::class, 'query'])->name('search.query');

    Route::get('d/{id}-{slug}', [threadController::class, 'show'])->name('threads.show');
    // Route::get('/u/{nameOrId}', [UserController::class, 'show'])->name('user.show');

    Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
    Route::get('/charter', [HomeController::class, 'charter'])->name('charter');
    Route::get('/metrics', [HomeController::class, 'metrics'])->name('metrics');

    Route::get('/p/{id}', [PostController::class, 'show'])->name('posts.show');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');

        Route::get('/settings', [UserSettingsController::class, 'index'])->name('user.settings');
        Route::get('/settings/profile/{name?}', [UserSettingsController::class, 'profile'])->name('user.settings.profile');
        Route::put('/settings/profile/{name?}', [UserSettingsController::class, 'updateProfile']);
        Route::get('/settings/account/email', [UserSettingsController::class, 'accountEmail'])->name('user.settings.account.email');
        Route::put('/settings/account/email', [UserSettingsController::class, 'updateAccountEmail']);
        Route::get('/settings/account/password', [UserSettingsController::class, 'accountPassword'])->name('user.settings.account.password');
        Route::put('/settings/account/password', [UserSettingsController::class, 'updateAccountPassword']);
        Route::get('/settings/account/security/2fa/enable', [UserSettingsController::class, 'enableAccount2FA'])->name('user.settings.account.security.2fa.enable');
        Route::get('/settings/account/security/2fa/disable', [UserSettingsController::class, 'disableAccount2FA'])->name('user.settings.account.security.2fa.disable');
        Route::get('/settings/layout', [UserSettingsController::class, 'layout'])->name('user.settings.layout');
        Route::put('/settings/layout', [UserSettingsController::class, 'updateLayout']);
        Route::get('/settings/notifications', [UserSettingsController::class, 'notifications'])->name('user.settings.notifications');
        Route::put('/settings/notifications', [UserSettingsController::class, 'updateNotifications']);
        Route::put('/settings/notifications/pushbullet', [UserSettingsController::class, 'updateNotificationsPushbullet'])->name('user.settings.notifications.pushbullet');
        Route::get('/settings/notifications/pushbullet/test', [UserSettingsController::class, 'notificationsPushbulletTest'])->name('user.settings.notifications.pushbullet.test');
        Route::get('/settings/connections', [ConnectionsController::class, 'index'])->name('user.settings.connections.index');
        Route::get('/settings/connections/regen-token', [ConnectionsController::class, 'regenToken'])->name('user.settings.connections.regen-token');

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/clear', [NotificationController::class, 'clear'])->name('notifications.clear');
        Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');

        Route::get('/d/p', [PrivatethreadController::class, 'index'])->name('private_threads.index');
        Route::get('/d/p/{user}-{name}/create', [PrivatethreadController::class, 'create'])->name('private_threads.create');
        Route::post('/d/p/{user}-{name}', [PrivatethreadController::class, 'store'])->name('private_threads.store');

        Route::get('/u/{user}/delete', [UserController::class, 'delete'])->name('user.delete');
        Route::delete('/u/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::get('d/create', [threadController::class, 'create'])->name('threads.create');
        Route::post('/d/preview', [threadController::class, 'preview'])->name('threads.preview');
        Route::post('d', [threadController::class, 'store'])->name('threads.store');
        Route::put('d/{thread}-{slug}/update', [threadController::class, 'update'])->name('threads.update');
        Route::get('d/{thread}-{slug}/p/{post}/edit', [threadPostController::class, 'edit'])->name('threads.posts.edit');
        Route::get('d/{thread}-{slug}/p/{post}/delete', [threadPostController::class, 'delete'])->name('threads.posts.delete');
        Route::put('d/{thread}-{slug}/p/{post}', [threadPostController::class, 'update'])->name('threads.posts.update');
        // Route::post('d/{thread}-{slug}/p/{post}/react', [threadPostController::class, 'react'])->name('threads.posts.react');
        Route::delete('d/{thread}-{slug}/p/{post}', [threadPostController::class, 'destroy'])->name('threads.posts.destroy');

        Route::get('d/{thread}-{slug}/subscribe', [threadController::class, 'subscribe'])->name('threads.subscribe');
        Route::get('d/{thread}-{slug}/unsubscribe', [threadController::class, 'unsubscribe'])->name('threads.unsubscribe');

        Route::get('/d/s', [threadController::class, 'subscriptions'])->name('threads.subscriptions');
    });

    Route::group(['prefix' => '/api/v0'], function () {
        Route::group(['middleware' => 'auth'], function () {
            Route::post('/webpush/subscribe', [ApiWebpushController::class, 'subscribe']);
            Route::get('/users/{id}/emojis', [ApiEmojiController::class, 'listForUser'])->name('api.users.emojis');
        });

        Route::get('/users', [ApiUsersController::class, 'index'])->name('api.users');
        Route::get('/users/all', [ApiUsersController::class, 'all'])->name('api.users.all');
        Route::get('/threads/{thread}', [ApithreadController::class, 'show']);
    });

    Route::view('/errors/403', 'errors/403');
    Route::view('/errors/404', 'errors/404');
    Route::view('/errors/410', 'errors/410');
    Route::view('/errors/429', 'errors/429');
    Route::view('/errors/500', 'errors/500');
    Route::view('/errors/503', 'errors/503');
});
