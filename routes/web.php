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
    Route::get('/discussions', 'DiscussionController@index')->name('discussions.index');

    Route::get('/discussions/{discussion}-{slug}', 'DiscussionController@show')->name('discussions.show');
    Route::get('/discussions/create', 'DiscussionController@create')->name('discussions.create');
    Route::post('/discussions', 'DiscussionController@store')->name('discussions.store');
    // Route::get('/discussions/{discussion}-{slug}', 'DiscussionPostController@create')->name('discussions.posts.create');
    Route::post('/discussions/{discussion}-{slug}/create', 'DiscussionPostController@store')->name('discussions.posts.store');
    Route::get('/discussions/{discussion}-{slug}/{post}/edit', 'DiscussionPostController@edit')->name('discussions.posts.edit');
    Route::put('/discussions/{discussion}-{slug}/{post}', 'DiscussionPostController@update')->name('discussions.posts.update');

    Route::get('/terms', 'HomeController@terms')->name('terms');

    // Route::resource('/discussions', 'DiscussionController');
    // Route::resource('/posts', 'PostController');
// });
