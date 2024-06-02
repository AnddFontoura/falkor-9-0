<?php

namespace App\Http\Service;

use App\Models\Matches;
use App\Models\MatchHasPlayer;
use App\Models\TeamPlayer;

class MatchHasPlayerService
{
    public function fillPlayersOnMatch(Matches $match, int $teamId)
    {
        $teamPlayers = TeamPlayer::where('team_id', $teamId)
            ->get();

        foreach($teamPlayers as $players) {
            $matchHasPlayer = MatchHasPlayer::where('match_id', $match->id)
                ->where('team_player_id', $players->id)
                ->first();

            if (!$matchHasPlayer) {
                MatchHasPlayer::create([
                    'match_id' => $match->id,
                    'team_player_id' => $players->id
                ]);
            }
        }
    }

    public function getPlayersOnMatch(int $matchId, int $teamId)
    {
        return MatchHasPlayer::join('team_players', 'team_players.id', '=', 'match_has_players.team_player_id')
            ->where('match_has_players.match_id', $matchId)
            ->where('team_players.team_id', $teamId)
            ->where('showed_up', true)
            ->orderBy('team_players.number', 'asc')
            ->get();
    }
}
