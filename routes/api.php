<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1',  'namespace' => 'Api\v1'], function () {
    Route::get('/@me', 'SelfController@me');
    Route::get('/light-toggler', 'SelfController@lightToggler');
    Route::get('/notifications', 'SelfController@notifications');
    Route::post('/discord-guilds', 'DiscordConnectorController@guilds');
    Route::post('/discord-emojis', 'DiscordConnectorController@emojis');
    Route::post('/discussions/{discussion}/posts', 'DiscussionPostController@store');
});
