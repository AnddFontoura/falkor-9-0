<?php

namespace App\Http\Controllers;

use App\Models\GamePosition;
use App\Models\Matches;
use App\Models\MatchHasPlayer;
use App\Models\Team;
use App\Models\TeamPlayer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

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
        $this->validate($request, [
            'playerNumber' => 'nullable|int|min:1',
            'playerPosition' => 'nullable|int|min:1',
            'showedUp' => 'nullable|in:true,false',
            'noShowReasion' => 'nullable|string|min:1',
        ]);

        $data = $request->only([
            'playerNumber',
            'playerPosition',
            'showedUp',
            'noShowReasion',
        ]);

        if ($data['showedUp'] == 'true') {
            $data['showedUp'] = 1;
        } else {
            $data['showedUp'] = 0;
        }

        $matchPlayerInfo = MatchHasPlayer::where('match_id', $matchId)
            ->where('team_player_id', $playerId)
            ->first();

        if ($matchPlayerInfo) {
            $matchPlayerInfo->update([
                'game_position_id' => $data['playerPosition'],
                'number' => $data['playerNumber'],
                'showed_up' => $data['showedUp'],
                'reason_for_absence' => $data['noShowReasion'],
            ]);
        } else {
            MatchHasPlayer::create(
                array_merge(
                    [
                        'game_position_id' => $data['playerPosition'],
                        'number' => $data['playerNumber'],
                        'showed_up' => $data['showedUp'],
                        'reason_for_absence' => $data['noShowReasion'],
                    ],
                    [
                        'team_player_id' => $playerId,
                        'match_id' => $matchId
                    ]
                )
            );
        }

        return response()->json(
            [
                'success' => 'Dados atualizados com sucesso'
            ],
            Response::HTTP_ACCEPTED
        );
    }

    public function playerConfirmation(int $teamId, Request $request)
    {
        $this->validate($request, [
            'matchId' => 'required|int|min:1',
            'confirmed' => 'required|int',
        ]);

        $data = $request->only([
            'matchId',
            'confirmed',
        ]);

        $teamPlayer = TeamPlayer::where('user_id', Auth::user()->id)->first();

        MatchHasPlayer::updateOrCreate(
            [
                'team_player_id' => $teamPlayer->id,
                'match_id' => $data['matchId'],
            ],
            [
                'confirmed' => $data['confirmed'],
            ]
        );

        return response()->json(
            [
                'success' => 'Dados atualizados com sucesso'
            ],
            Response::HTTP_ACCEPTED
        );
    }
}
