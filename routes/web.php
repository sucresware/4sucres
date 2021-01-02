<?php

use App\Http\Controllers\Next\Auth\LoginController;
use App\Http\Controllers\Next\BoardController;
use App\Http\Controllers\Next\HomeController;
use App\Http\Controllers\Next\threadController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'next');

Route::group(['prefix' => 'next', 'as' => 'next.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/b', fn () => redirect()->route('next.boards.show', 'all'))->name('boards.index');
    Route::get('/b/{board_slug}', [BoardController::class, 'show'])->name('boards.show');
    Route::get('/b/{board_slug}/{thread_id}/{thread_slug?}', [BoardController::class, 'show'])->name('threads.show');

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
