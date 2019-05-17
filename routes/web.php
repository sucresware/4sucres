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

Route::get('/login', 'Auth\LoginController@login')->name('login');
Route::post('/login', 'Auth\LoginController@submit');

Route::get('/d', 'DiscussionController@index')->name('discussions.index');
Route::get('/d/c/{category}-{slug}', 'DiscussionController@index')->name('discussions.categories.index');

Route::get('d/{id}-{slug}', 'DiscussionController@show')->name('discussions.show');
Route::get('/u/{name}', 'UserController@show')->name('user.show');

Route::get('/terms', 'HomeController@terms')->name('terms');
Route::get('/charter', 'HomeController@charter')->name('charter');
Route::get('/leaderboard', 'HomeController@leaderboard')->name('leaderboard');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::get('/settings', 'UserController@settings')->name('user.settings');
    Route::put('/settings', 'UserController@saveSettings');

    Route::get('/notifications', 'NotificationController@index')->name('notifications.index');
    Route::get('/notifications/clear', 'NotificationController@clear')->name('notifications.clear');
    Route::get('/notifications/{notification}', 'NotificationController@show')->name('notifications.show');

    Route::get('/d/p', 'PrivateDiscussionController@index')->name('private_discussions.index');
    Route::get('/d/p/{user}-{name}/create', 'PrivateDiscussionController@create')->name('private_discussions.create');
    Route::post('/d/p/{user}-{name}', 'PrivateDiscussionController@store')->name('private_discussions.store');

    Route::get('/u/{user}/edit', 'UserController@edit')->name('user.edit');
    Route::put('/u/{user}', 'UserController@update')->name('user.update');

    Route::get('d/create', 'DiscussionController@create')->name('discussions.create');
    Route::post('/d/preview', 'DiscussionController@preview')->name('discussions.preview');
    Route::post('d', 'DiscussionController@store')->name('discussions.store');
    Route::put('d/{discussion}-{slug}/update', 'DiscussionController@update')->name('discussions.update');
    Route::post('d/{discussion}-{slug}/create', 'DiscussionPostController@store')->name('discussions.posts.store');
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

        Route::post('/webpush/subscribe', function (\Illuminate\Http\Request $request) {
            user()->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));
            return response()->json(['success' => true]);
        });
    });

    Route::get('/discussions/{discussion}', 'Api\DiscussionController@show');
});

if (config('app.env') == 'local') {
    Route::get('/storage/avatars/{file}', function ($file) {
        if (!File::exists(base_path($file))) $file = 'public/img/guest.png';
        return response()->file(base_path($file));
    });
}
