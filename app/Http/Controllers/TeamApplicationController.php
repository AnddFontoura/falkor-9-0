<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use App\Models\TeamApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamApplicationController extends Controller
{
    public string $viewFolder = 'system/team-application/';
    public function index(Request $request, Team $team)
    {

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
