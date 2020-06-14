<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'AdminController@index')->name('index');
Route::get('/activity', 'ActivityController@index')->name('activity.index');
Route::get('/activity/{activity}', 'ActivityController@show')->name('activity.show');

Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/console', 'ConsoleController@index')->name('console.index');
    Route::get('/console/run/{command}', 'ConsoleController@run')->name('console.run');
});
