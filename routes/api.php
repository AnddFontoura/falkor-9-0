<?php

use App\Http\Controllers\MatchHasPlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::name('api.')
    //->middleware('auth')
    ->group(function() {
    Route::prefix('team-has-player')
        ->controller(MatchHasPlayerController::class)
        ->name('team-has-player.')
        ->group(function() {
            Route::post('save/team/{matchId}/player/{playerId}', 'save')->name('save_or_update');
    });
});