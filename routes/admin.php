<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserAdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
        ->name('admin.')
        ->middleware(['auth','isAdmin',])
        ->group(function() {
            Route::get('/', [AdminController::class, 'index'])->name('index');

            Route::prefix('user')
                ->name('user.')
                ->controller(UserAdminController::class)
                ->group(function() {
                    Route::get('/', 'index')->name('index');
                    Route::get('show/{userId}', 'show')->name('show');
                    Route::get('edit/{userId}', 'edit')->name('edit');
                    Route::patch('update/{userId}', 'update')->name('update');
                    Route::delete('delete/{userId}', 'destroy')->name('delete');
                    Route::patch('restore/{userId}', 'restore')->name('restore');
                });
        });
