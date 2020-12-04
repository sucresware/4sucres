<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ConsoleController;
use App\Http\Controllers\Admin\ActivityController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AdminController::class, 'index'])->name('index');
Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
Route::get('/activity/{activity}', [ActivityController::class, 'show'])->name('activity.show');

Route::group(['middleware' => 'role:admin'], function () {
    Route::get('/console', [ConsoleController::class, 'index'])->name('console.index');
    Route::get('/console/run/{command}', [ConsoleController::class, 'run'])->name('console.run');
});
