<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\SelfController;
use App\Http\Controllers\Api\v1\DiscussionPostController;
use App\Http\Controllers\Api\v1\DiscordConnectorController;

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

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function () {
    Route::get('/@me', [SelfController::class, 'me']);
    Route::get('/light-toggler', [SelfController::class, 'lightToggler']);
    Route::get('/notifications', [SelfController::class, 'notifications']);
    Route::post('/discord-guilds', [DiscordConnectorController::class, 'guilds']);
    Route::post('/discord-emojis', [DiscordConnectorController::class, 'emojis']);
    Route::post('/discussions/{discussion}/posts', [DiscussionPostController::class, 'store']);
});
