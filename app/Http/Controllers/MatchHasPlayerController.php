<?php

namespace App\Http\Controllers;

use App\Models\GamePosition;
use App\Models\Matches;
use App\Models\MatchHasPlayer;
use App\Models\Team;
use App\Models\TeamPlayer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MatchHasPlayerController extends Controller
{
    protected string $viewFolder = 'system.match-has-player.';
    protected string $saveRedirect = 'system/team/manage';

    public function form(int $teamId, int $matchId)
    {
        $team = Team::where('id', $teamId)->first();
        $match = Matches::where('id', $matchId)->first();
        $gamePositions = GamePosition::get();

        $teamPlayers = TeamPlayer::where('team_players.team_id', $teamId)
            ->get();

        foreach($teamPlayers as $player) {
            $hasMatchInfo = MatchHasPlayer::where('match_id', $matchId)
                ->where('team_player_id', $player->id)
                ->first();

            $player->matchHasPlayerInfo = $hasMatchInfo;
        }

        return view($this->viewFolder . 'form', compact('team', 'match', 'teamPlayers', 'gamePositions'));
    }

    public function save(Request $request, int $matchId, int $playerId)
    {

        return response()->json('', Response::HTTP_BAD_REQUEST);
    }
}
