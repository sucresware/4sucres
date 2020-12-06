<?php

use App\Http\Controllers\Next\Auth\LoginController;
use App\Http\Controllers\Next\DiscussionController;
use App\Http\Controllers\Next\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'next');

Route::group(['prefix' => 'next', 'as' => 'next.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/discussions', [DiscussionController::class, 'index'])->name('discussions.index');
    Route::get('/discussions/{discussionId}/{slug?}', [DiscussionController::class, 'index'])->name('discussions.show');

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'submit']);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
