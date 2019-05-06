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

// Route::get('/', 'HomeController@index')->name('home');

// Route::view('/', 'landing');
// Route::post('optin', function () {
//     request()->validate([
//         'email' => 'required|email',
//     ]);

//     try {
//         $optins = json_decode(file_get_contents(storage_path('app/optins.json')));
//     } catch (\Exception $e) {
//         $optins = [];
//     }
//     $optins[] = request()->input('email');
//     file_put_contents(storage_path('app/optins.json'), json_encode($optins));

//     return redirect('/')->with('success', 'C\'est noté le sucre !');
// });

// Route::group(['middleware' => 'auth.basic'], function () {
    // Auth::routes();

    Route::get('/register', 'Auth\RegisterController@register')->name('register');
    Route::post('/register', 'Auth\RegisterController@submit');
    Route::get('/auth/verify_email/{token}', 'Auth\RegisterController@verify')->name('auth.verify_email');

    Route::get('/login', 'Auth\LoginController@login')->name('login');
    Route::post('/login', 'Auth\LoginController@submit');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/', 'DiscussionController@index')->name('home');
    Route::get('/d', 'DiscussionController@index')->name('discussions.index');
    Route::get('/d/c/{category}-{slug}', 'DiscussionController@index')->name('discussions.categories.index');

    Route::get('/profile', 'UserController@profile')->name('profile');
    Route::get('/u/{user}-{name}', 'UserController@show')->name('user.show');

    Route::get('d/{discussion}-{slug}', 'DiscussionController@show')->name('discussions.show');
    Route::get('d/create', 'DiscussionController@create')->name('discussions.create');
    Route::post('d', 'DiscussionController@store')->name('discussions.store');
    Route::put('d/{discussion}-{slug}/update', 'DiscussionController@update')->name('discussions.update');
    // Route::get('d/{discussion}-{slug}', 'DiscussionPostController@create')->name('discussions.posts.create');
    Route::post('d/{discussion}-{slug}/create', 'DiscussionPostController@store')->name('discussions.posts.store');
    Route::get('d/{discussion}-{slug}/p/{post}/edit', 'DiscussionPostController@edit')->name('discussions.posts.edit');
    Route::get('d/{discussion}-{slug}/p/{post}/delete', 'DiscussionPostController@delete')->name('discussions.posts.delete');
    Route::put('d/{discussion}-{slug}/p/{post}', 'DiscussionPostController@update')->name('discussions.posts.update');
    Route::delete('d/{discussion}-{slug}/p/{post}', 'DiscussionPostController@destroy')->name('discussions.posts.destroy');

    Route::get('/terms', 'HomeController@terms')->name('terms');
    Route::get('/charte', 'HomeController@charte')->name('charte');

    Route::get('/leaderboard', 'HomeController@leaderboard')->name('leaderboard');

    // Route::resource('d', 'DiscussionController');
    // Route::resource('/posts', 'PostController');
// });
