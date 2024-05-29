<?php

use App\Http\Controllers\MatchHasPlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your Admin!
|
*/

Route::prefix('admin')
        ->controller(AdminController::class)
        ->name('admin.')
        ->middleware(['auth','isAdmin',])
        ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('show/{userId}', 'show')->name('show');
        Route::get('edit/{userId}', 'edit')->name('edit');
        Route::patch('update/{userId}', 'update')->name('update');
        Route::delete('delete/{userId}', 'destroy')->name('delete');
        Route::patch('restore/{userId}', 'restore')->name('restore');
    });