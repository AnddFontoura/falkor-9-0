<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\MatchHasPlayer;
use App\Models\Team;
use App\Models\TeamPlayer;
use Illuminate\Http\Request;

class MatchHasPlayerController extends Controller
{
    protected string $viewFolder = 'system.match-has-player.';
    protected string $saveRedirect = 'system/team/manage';

    public function form(int $teamId, int $matchId)
    {
        $team = Team::where('id', $teamId)->first();
        $match = Matches::where('id', $matchId)->first();
        $teamPlayers = TeamPlayer::where('team_players.team_id', $teamId)
            ->get();

        foreach($teamPlayers as $player) {
            $hasMatchInfo = MatchHasPlayer::where('match_id', $matchId)
                ->where('team_player_id', $player->id)
                ->first();

            $player->matchHasPlayerInfo = $hasMatchInfo;
        }

        return view($this->viewFolder . 'form', compact('team', 'match', 'teamPlayers'));
    }
}
