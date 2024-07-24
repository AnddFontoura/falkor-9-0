<?php

namespace App\Http\Controllers;

use App\Models\FriendlyGame;
use App\Models\FriendlyGameOpponent;
use Illuminate\Http\Request;

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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(FriendlyGameOpponent $friendlyGameOpponent)
    {
        //
    }

    public function edit(FriendlyGameOpponent $friendlyGameOpponent)
    {
        //
    }

    public function update(Request $request, FriendlyGameOpponent $friendlyGameOpponent)
    {
        //
    }

    public function destroy(FriendlyGameOpponent $friendlyGameOpponent)
    {
        //
    }
}
