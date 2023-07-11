<?php

namespace App\Http\Controllers;

use App\Mail\TeamPlayerInvitationMail;
use App\Models\PlayerInvitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class PlayerInvitationController extends Controller
{
    public function createInvitationByEmail(Request $request, int $teamId)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'teamPlayerId' => 'required|int'
        ]);

        $data = $request->only([
            'email',
            'teamPlayerId'
        ]);

        $teamPlayer = PlayerInvitation::where('team_id', $teamId)
            ->where('team_player_id', $data['teamPlayerId'])
            ->first();
    
        if($teamPlayer) {
            return response()->json(['error' => 'Email já cadastrado nesse time'], Response::HTTP_BAD_REQUEST);
        }

        PlayerInvitation::create([
            'team_id' => $teamId,
            'team_player_id' => $data['teamPlayerId'],
            'email' => $data['email']
        ]);

        $fakeUser = (new User(['email' => $data['email'], 'name' => 'FakeName']));

        Mail::to($fakeUser)->send(new TeamPlayerInvitationMail($data['email']));

        return response()->json(['success' => 'Convite enviado ao jogador']);
    }
}
