<?php

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

Route::get('/', 'DiscussionController@index')->name('home');

Route::get('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/register', 'Auth\RegisterController@submit');
Route::get('/auth/verify_email/{token}', 'Auth\RegisterController@verify')->name('auth.verify_email');

Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/password/reset/{token}', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/login', 'Auth\LoginController@submit');

Route::get('/d', 'DiscussionController@index')->name('discussions.index');
Route::get('/d/c/{category}-{slug}', 'DiscussionController@index')->name('discussions.categories.index');

Route::get('/search', 'SearchController@query')->name('search.query');

Route::get('d/{id}-{slug}', 'DiscussionController@show')->name('discussions.show');
Route::get('/u/{nameOrId}', 'UserController@show')->name('user.show');

Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/charter', 'HomeController@charter')->name('charter');
Route::get('/leaderboard', 'HomeController@leaderboard')->name('leaderboard');

Route::get('/p/{id}', 'PostController@show')->name('posts.show');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/profile', 'UserController@profile')->name('profile');

    Route::get('/settings', 'UserSettingsController@index')->name('user.settings');
    Route::get('/settings/profile/{name?}', 'UserSettingsController@profile')->name('user.settings.profile');
    Route::put('/settings/profile/{name?}', 'UserSettingsController@updateProfile');
    Route::get('/settings/account/email', 'UserSettingsController@accountEmail')->name('user.settings.account.email');
    Route::put('/settings/account/email', 'UserSettingsController@updateAccountEmail');
    Route::get('/settings/account/password', 'UserSettingsController@accountPassword')->name('user.settings.account.password');
    Route::put('/settings/account/password', 'UserSettingsController@updateAccountPassword');
    Route::get('/settings/layout', 'UserSettingsController@layout')->name('user.settings.layout');
    Route::put('/settings/layout', 'UserSettingsController@updateLayout');
    Route::get('/settings/notifications', 'UserSettingsController@notifications')->name('user.settings.notifications');
    Route::put('/settings/notifications', 'UserSettingsController@updateNotifications');
    Route::put('/settings/notifications/pushbullet', 'UserSettingsController@updateNotificationsPushbullet')->name('user.settings.notifications.pushbullet');
    Route::get('/settings/notifications/pushbullet/test', 'UserSettingsController@notificationsPushbulletTest')->name('user.settings.notifications.pushbullet.test');
    Route::get('/settings/connections', 'Settings\ConnectionsController@index')->name('user.settings.connections.index');
    Route::get('/settings/connections/regen-token', 'Settings\ConnectionsController@regenToken')->name('user.settings.connections.regen-token');

    Route::get('/notifications', 'NotificationController@index')->name('notifications.index');
    Route::get('/notifications/clear', 'NotificationController@clear')->name('notifications.clear');
    Route::get('/notifications/{notification}', 'NotificationController@show')->name('notifications.show');

    Route::get('/d/p', 'PrivateDiscussionController@index')->name('private_discussions.index');
    Route::get('/d/p/{user}-{name}/create', 'PrivateDiscussionController@create')->name('private_discussions.create');
    Route::post('/d/p/{user}-{name}', 'PrivateDiscussionController@store')->name('private_discussions.store');

    Route::get('/u/{user}/delete', 'UserController@delete')->name('user.delete');
    Route::delete('/u/{user}', 'UserController@destroy')->name('user.destroy');

    Route::get('d/create', 'DiscussionController@create')->name('discussions.create');
    Route::post('/d/preview', 'DiscussionController@preview')->name('discussions.preview');
    Route::post('d', 'DiscussionController@store')->name('discussions.store');
    Route::put('d/{discussion}-{slug}/update', 'DiscussionController@update')->name('discussions.update');
    Route::get('d/{discussion}-{slug}/p/{post}/edit', 'DiscussionPostController@edit')->name('discussions.posts.edit');
    Route::get('d/{discussion}-{slug}/p/{post}/delete', 'DiscussionPostController@delete')->name('discussions.posts.delete');
    Route::put('d/{discussion}-{slug}/p/{post}', 'DiscussionPostController@update')->name('discussions.posts.update');
    // Route::post('d/{discussion}-{slug}/p/{post}/react', 'DiscussionPostController@react')->name('discussions.posts.react');
    Route::delete('d/{discussion}-{slug}/p/{post}', 'DiscussionPostController@destroy')->name('discussions.posts.destroy');

    Route::get('d/{discussion}-{slug}/subscribe', 'DiscussionController@subscribe')->name('discussions.subscribe');
    Route::get('d/{discussion}-{slug}/unsubscribe', 'DiscussionController@unsubscribe')->name('discussions.unsubscribe');

    Route::get('/d/s', 'DiscussionController@subscriptions')->name('discussions.subscriptions');
});

Route::group(['prefix' => '/api/v0'], function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::post('/imgur-gateway/upload', 'Api\ImgurGatewayController@upload');
        Route::post('/webpush/subscribe', 'Api\WebpushController@subscribe');
        Route::get('/users/{id}/emojis', 'Api\EmojiController@listForUser')->name('api.users.emojis');
    });

    Route::get('/users', 'Api\UsersController@index')->name('api.users');
    Route::get('/users/all', 'Api\UsersController@all')->name('api.users.all');
    Route::get('/discussions/{discussion}', 'Api\DiscussionController@show');
});

Route::view('/errors/403', 'errors/403');
Route::view('/errors/404', 'errors/404');
Route::view('/errors/410', 'errors/410');
Route::view('/errors/429', 'errors/429');
Route::view('/errors/500', 'errors/500');
Route::view('/errors/503', 'errors/503');
