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

    public function storeOpponent(
        FriendlyGameOpponentCreateOrUpdateRequest $request,
        int $friendlyGameId
    ) {
        $data = $request->validated();

        $friendlyGameIsOpponent = FriendlyGameOpponent::where('friendly_game_id', $friendlyGameId)
        ->where('opponent_id', $data['opponentTeamId'])
        ->first();

        if ($friendlyGameIsOpponent) {
            return back()->with(['error' => 'Você já pediu um amistoso com esse time']);
        }

        FriendlyGameOpponent::create([
            'friendly_game_id' => $friendlyGameId,
            'opponent_id' => $data['opponentTeamId'],
            'main_uniform_color' => $data['opponent1stUniform'],
            'secondary_uniform_color' => $data['opponent2ndUniform'],
        ]);

        return redirect()->route('system.friendly-game.index')->with([
            'success' => 'Seu pedido de amistoso foi enviado. Fique de olho para a resposta!'
        ]);
    }

    public function storeFriendlyGameDecision()
    {
        //
    }
}
