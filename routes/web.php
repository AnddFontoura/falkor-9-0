<?php

use App\Models\MatchHasPlayer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\TeamPlayerController;
use App\Http\Controllers\MatchHasPlayerController;
use App\Http\Controllers\PlayerInvitationController;

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

Auth::routes(['verify' => true]);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('system')->middleware('auth')->name('system.')->group(function() {
    Route::prefix('team')
        ->controller(TeamController::class)
        ->name('team.')
        ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'form')->name('form_create')->middleware('verified');
        Route::get('create/{teamId}', 'form')->name('form_update')->middleware(['isTeamManager', 'verified']);
        Route::post('save', 'store')->name('save')->middleware('verified');
        Route::post('save/{teamId}', 'store')->name('update')->middleware(['isTeamManager', 'verified']);
        Route::get('show/{teamId}', 'show')->name('show');
        Route::delete('delete/{teamId}', 'show')->name('delete')->middleware(['isTeamManager', 'verified']);
        Route::get('manage/{teamId}', 'manage')->name('manage')->middleware(['isTeamManager', 'verified']);
    });

    Route::prefix('team-player/{teamId}')
        ->controller(TeamPlayerController::class)
        ->name('team-player.')
        ->middleware(['isTeamManager', 'verified'])
        ->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'form')->name('form_create');
            Route::get('create/{playerId}', 'form')->name('form_update');
            Route::post('save', 'store')->name('save');
            Route::post('save/{playerId}', 'store')->name('update');
            Route::get('show/{playerId}', 'show')->name('show');
            Route::delete('delete/{playerId}', 'show')->name('delete');
    });

    Route::prefix('player')
        ->controller(PlayerController::class)
        ->name('player.')
        ->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'form')->middleware('verified')->name('form_create');
            Route::get('create/{playerId}', 'form')->middleware('verified')->name('form_update');
            Route::post('save', 'store')->middleware('verified')->name('save');
            Route::post('save/{playerId}', 'store')->middleware('verified')->name('update');
            Route::get('show/{playerId}', 'show')->name('show');
    });

    Route::prefix('player-invitation')
        ->controller(PlayerInvitationController::class)
        ->name('player-invitation.')
        ->middleware(['isTeamManager', 'verified'])
        ->group(function() {
            Route::post('{teamId}/email-invitation', 'createInvitationByEmail')->name('email-invitation');
    });

    Route::prefix('player-invitation')
        ->controller(PlayerInvitationController::class)
        ->name('player-invitation.')
        ->middleware(['verified'])
        ->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('accept', 'accept')->name('accept');
            Route::post('refuse', 'refuse')->name('refuse');
    });

    Route::prefix('matches/{teamId}')
        ->controller(MatchesController::class)
        ->name('matches.')
        ->middleware(['verified'])
        ->group(function() {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'form')->name('form_create');
            Route::get('create/{matchId}', 'form')->name('form_update');
            Route::post('save', 'store')->name('save');
            Route::post('save/{matchId}', 'store')->name('update');
            Route::get('show/{matchId}', 'show')->name('show');
            Route::delete('delete/{matchId}', 'show')->name('delete');
        });

    Route::prefix('matches')
        ->controller(MatchesController::class)
        ->name('matches_wt.')
        ->group(function() {
            Route::get('/', 'list')->name('index');
            Route::get('show/{matchId}', 'view')->name('show');
        });
    
    Route::prefix('match-players/{teamId}')
        ->controller(MatchHasPlayerController::class)
        ->name('match-players.')
        ->middleware(['isTeamManager', 'verified'])
        ->group(function() {
            Route::get('create/{matchId}', 'form')->name('form');
            Route::post('update/{matchId}', 'store')->name('update');
        });
        
    Route::prefix('field')
        ->controller(FieldController::class)
        ->name('field.')
        ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'form')->name('form_create')->middleware('verified');
        Route::get('create/{fieldId}', 'form')->name('form_update')->middleware(['isTeamManager', 'verified']);
        Route::post('save', 'store')->name('save')->middleware('verified');
        Route::post('save/{fieldId}', 'store')->name('update')->middleware(['isTeamManager', 'verified']);
        Route::get('show/{fieldId}', 'show')->name('show');
        Route::delete('delete/{fieldId}', 'show')->name('delete')->middleware(['isTeamManager', 'verified']);
        Route::get('manage/{fieldId}', 'manage')->name('manage')->middleware(['isTeamManager', 'verified']);
    });
});

