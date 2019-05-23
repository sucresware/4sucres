<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'AdminController@index')->name('index');
Route::get('/activity', 'ActivityController@index')->name('activity.index');
Route::get('/activity/data', 'ActivityController@data')->name('activity.data');
