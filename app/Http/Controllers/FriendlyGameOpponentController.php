<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendlyGameOpponentCreateOrUpdateRequest;
use App\Models\FriendlyGameOpponent;

class FriendlyGameOpponentController extends Controller
{
    public function index(int $friendlyGameId)
    {
        $friendlyGameOpponents = FriendlyGameOpponent::where('friendly_game_id', $friendlyGameId)
            ->get();

        return view('', compact(

            'friendlyGameOpponents'
        ));
    }

    public function storeOpponent(FriendlyGameOpponentCreateOrUpdateRequest $request)
    {
        //
    }

    public function storeFriendlyGameDecision()
    {
        //
    }
}
