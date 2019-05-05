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

Route::view('/', 'landing');
Route::post('optin', function(){
    request()->validate([
        'email' => 'required|email'
    ]);

    try {
        $optins = json_decode(file_get_contents(storage_path('app/optins.json')));
    } catch (\Exception $e){
        $optins = [];
    }
    $optins[] = request()->input('email');
    file_put_contents(storage_path('app/optins.json'), json_encode($optins));

    return redirect('/')->with('success', 'C\'est noté le sucre !');
});

Route::group(['middleware' => 'auth.basic'], function(){
    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/discussions/{id}-{slug}', 'DiscussionController@show')->name('discussion.show');
});
