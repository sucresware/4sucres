<?php

use App\Http\Controllers\Api\DiscussionController as ApiDiscussionController;
use App\Http\Controllers\Api\EmojiController as ApiEmojiController;
use App\Http\Controllers\Api\UsersController as ApiUsersController;
use App\Http\Controllers\Api\WebpushController as ApiWebpushController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\DiscussionPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PrivateDiscussionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Settings\ConnectionsController;
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

    Route::get('/', [DiscussionController::class, 'index'])->name('home');

    Route::get('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/register', [RegisterController::class, 'submit']);
    Route::get('/auth/verify_email/{token}', [RegisterController::class, 'verify'])->name('auth.verify_email');

    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset/{token}', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('/d', [DiscussionController::class, 'index'])->name('discussions.index');
    Route::get('/d/c/{category}-{slug}', [DiscussionController::class, 'index'])->name('discussions.categories.index');

    Route::get('/search', [SearchController::class, 'query'])->name('search.query');

    Route::get('d/{id}-{slug}', [DiscussionController::class, 'show'])->name('discussions.show');
    Route::get('/u/{nameOrId}', [UserController::class, 'show'])->name('user.show');

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

        Route::get('/d/p', [PrivateDiscussionController::class, 'index'])->name('private_discussions.index');
        Route::get('/d/p/{user}-{name}/create', [PrivateDiscussionController::class, 'create'])->name('private_discussions.create');
        Route::post('/d/p/{user}-{name}', [PrivateDiscussionController::class, 'store'])->name('private_discussions.store');

        Route::get('/u/{user}/delete', [UserController::class, 'delete'])->name('user.delete');
        Route::delete('/u/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::get('d/create', [DiscussionController::class, 'create'])->name('discussions.create');
        Route::post('/d/preview', [DiscussionController::class, 'preview'])->name('discussions.preview');
        Route::post('d', [DiscussionController::class, 'store'])->name('discussions.store');
        Route::put('d/{discussion}-{slug}/update', [DiscussionController::class, 'update'])->name('discussions.update');
        Route::get('d/{discussion}-{slug}/p/{post}/edit', [DiscussionPostController::class, 'edit'])->name('discussions.posts.edit');
        Route::get('d/{discussion}-{slug}/p/{post}/delete', [DiscussionPostController::class, 'delete'])->name('discussions.posts.delete');
        Route::put('d/{discussion}-{slug}/p/{post}', [DiscussionPostController::class, 'update'])->name('discussions.posts.update');
        // Route::post('d/{discussion}-{slug}/p/{post}/react', [DiscussionPostController::class, 'react'])->name('discussions.posts.react');
        Route::delete('d/{discussion}-{slug}/p/{post}', [DiscussionPostController::class, 'destroy'])->name('discussions.posts.destroy');

        Route::get('d/{discussion}-{slug}/subscribe', [DiscussionController::class, 'subscribe'])->name('discussions.subscribe');
        Route::get('d/{discussion}-{slug}/unsubscribe', [DiscussionController::class, 'unsubscribe'])->name('discussions.unsubscribe');

        Route::get('/d/s', [DiscussionController::class, 'subscriptions'])->name('discussions.subscriptions');
    });

    Route::group(['prefix' => '/api/v0'], function () {
        Route::group(['middleware' => 'auth'], function () {
            Route::post('/webpush/subscribe', [ApiWebpushController::class, 'subscribe']);
            Route::get('/users/{id}/emojis', [ApiEmojiController::class, 'listForUser'])->name('api.users.emojis');
        });

        Route::get('/users', [ApiUsersController::class, 'index'])->name('api.users');
        Route::get('/users/all', [ApiUsersController::class, 'all'])->name('api.users.all');
        Route::get('/discussions/{discussion}', [ApiDiscussionController::class, 'show']);
    });

    Route::view('/errors/403', 'errors/403');
    Route::view('/errors/404', 'errors/404');
    Route::view('/errors/410', 'errors/410');
    Route::view('/errors/429', 'errors/429');
    Route::view('/errors/500', 'errors/500');
    Route::view('/errors/503', 'errors/503');
});
