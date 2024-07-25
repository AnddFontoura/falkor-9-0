<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use App\Models\TeamApplication;
use App\Models\TeamPlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamApplicationController extends Controller
{
    public string $viewFolder = 'system/team-application/';
    public function index(Request $request)
    {
        $teamApplications = [];

        $this->validate($request, [
            'applicationApproved' => 'nullable|integer|between:0,1',
        ]);

        $filter = $request->only([
            'applicationApproved',
        ]);

        $playerProfile = Player::where('user_id', Auth::id())->first();
        if ($playerProfile) {
            $teamApplications = TeamApplication::where('player_id', $playerProfile->id);

            if (isset($filter['applicationApproved'])) {
                $teamApplications = $teamApplications->where(
                    'application_approved',
                    $filter['applicationApproved']
                );
            }

            $teamApplications = $teamApplications
                ->orderBy('created_at', 'desc')
                ->paginate();
        }

        return view($this->viewFolder . 'index',
            compact(
                'teamApplications',
                'playerProfile',
            )
        );
    }
   public function create()
    {
        //
    }
    public function store(Request $request, int $teamId, int $userId)
    {
        $this->validate($request, [
           'gamePositionId' => 'required|integer'
        ]);

        $data = $request->only([
            'gamePositionId',
        ]);

        $hasProfile = Player::where('user_id', $userId)->first();

        if (!$hasProfile) {
            return response()->json(
                [
                    'error' => 'Você não tem um perfil ativo na plataforma. Crie o seu no menu "Jogador"'
                ],
                400
            );
        }

        $hasApplication = TeamApplication::where('team_id', $teamId)
            ->where('player_id', $hasProfile->id)
            ->first();

        if ($hasApplication) {
            return response()->json(
                [
                    'error' => 'Você já se candidatou a esse time uma vez'
                ],
                400
            );
        }

        TeamApplication::create([
            'team_id' => $teamId,
            'player_id' => $hasProfile->id,
            'game_position_id' => $data['gamePositionId'],
        ]);

        return response()->json(
            [
                'success' => 'Aplicação enviada com sucesso'
            ]
        );
    }

    public function result(Request $request, int $teamId)
    {
        $message = [
            'message' => 'Você tentou alterar o conteúdo do request e por isso nada foi feito'
        ];
        $status = 402;

        $this->validate($request, [
            'applicationResult' => 'required|int',
            'rejectDescription' => 'nullable|string',
            'applicationId' => 'required|integer'
        ]);

        $data = $request->only([
            'applicationResult',
            'rejectDescription',
            'applicationId'
        ]);

        $hasApplication = TeamApplication::where('team_id', $teamId)
            ->where('id', $data['applicationId'])
            ->first();

        if ($hasApplication) {
            if ($data['applicationResult'] == 1) {
                $playerInfo = Player::where('id', $hasApplication->player_id)->first();

                TeamPlayer::create([
                    'user_id' => $playerInfo->user_id,
                    'team_id' => $teamId,
                    'game_position_id' => $hasApplication->game_position_id,
                    'active' => 1,
                    'name' => $playerInfo->name,
                    'nickname' => $playerInfo->nickname,
                    'uniform_size' => $playerInfo->uniform_size,
                    'height' => $playerInfo->height,
                    'weight' => $playerInfo->weight,
                    'foot_size' => $playerInfo->foot_size,
                    'glove_size' => $playerInfo->glove_size,
                    'birthdate' => $playerInfo->birthdate,
                ]);

                $hasApplication->approved = $data['applicationResult'];
                $hasApplication->rejection_reason = $data['rejectDescription'];
                $hasApplication->update();

                $message = [
                    'message' => 'Jogador adicionado ao time com sucesso'
                ];
            } else {
                $hasApplication->approved = $data['applicationResult'];
                $hasApplication->rejection_reason = $data['rejectDescription'];
                $hasApplication->update();

                $message = [
                    'message' => 'Jogador recusado'
                ];
            }
            $status = 200;
        }

        return response()->json($message, $status);
    }
}
