<?php

use App\Http\Controllers\Next\Auth\LoginController;
use App\Http\Controllers\Next\BoardController;
use App\Http\Controllers\Next\threadController;
use App\Http\Controllers\Next\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'next');

Route::group(['prefix' => 'next', 'as' => 'next.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Shortcuts
    Route::get('/all', [BoardController::class, 'show'])->name('boards.all');

    Route::get('/boards/{board_slug?}', [BoardController::class, 'show'])->name('boards.show');
    Route::get('/threads/{board_slug}/{thread_id}/{thread_slug?}', [BoardController::class, 'show'])->name('threads.show');

    // Route::get('/threads', [threadController::class, 'index'])->name('threads.index');
    // Route::get('/threads/{threadId}/{slug?}', [threadController::class, 'index'])->name('threads.show');

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/login', [LoginController::class, 'submit']);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
