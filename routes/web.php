<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('system')->middleware('auth')->name('system.')->group(function() {
    Route::prefix('team')
        ->controller(TeamController::class)
        ->name('team.')
        ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'form')->name('form_create');
        Route::get('create/{id}', 'form')->name('form_update');
        Route::post('save', 'store')->name('save');
        Route::post('save/{id}', 'store')->name('update');
        Route::get('show/{id}', 'show')->name('show');
        Route::delete('delete/{id}', 'show')->name('delete');
        Route::delete('manage/{id}', 'manage')->name('manage');
    });
});