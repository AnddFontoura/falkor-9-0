<?php

namespace App\Http\Controllers;

use App\Mail\TeamPlayerInvitationMail;
use App\Models\PlayerInvitation;
use App\Models\TeamPlayer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PlayerInvitationController extends Controller
{
    protected string $viewFolder = 'system.player-invitation.';
    protected string $saveRedirect = 'system/player-invitation';
    protected PlayerInvitation $model;

    public function __construct(PlayerInvitation $model)
    {
        $this->model = $model;
    }

    public function index(): View
    {
        $playerInvitations = $this->model
            ->where('email', Auth::user()->email)
            ->orWhere('user_id', Auth::user()->email)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view($this->viewFolder . 'index', compact('playerInvitations'));
    }

    public function createInvitationByEmail(Request $request, int $teamId): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email',
            'teamPlayerId' => 'required|int'
        ]);

        $data = $request->only([
            'email',
            'teamPlayerId'
        ]);

        $teamPlayer = $this->model->where('team_id', $teamId)
            ->where('team_player_id', $data['teamPlayerId'])
            ->first();

        if($teamPlayer) {
            return response()->json(['error' => 'Email já cadastrado nesse time'], Response::HTTP_BAD_REQUEST);
        }

        $this->model->create([
            'team_id' => $teamId,
            'team_player_id' => $data['teamPlayerId'],
            'email' => $data['email']
        ]);

        $fakeUser = (new User(['email' => $data['email'], 'name' => 'FakeName']));

        Mail::to($fakeUser)->send(new TeamPlayerInvitationMail($data['email']));

        return response()->json(['success' => 'Convite enviado ao jogador']);
    }

    public function accept(Request $request): JsonResponse
    {
        $this->validate($request, [
            'invitationId' => 'required|int'
        ]);

        $data = $request->only([
            'invitationId'
        ]);

        $playerInvitation = PlayerInvitation::where('id', $data['invitationId'])->first();
        $isSameEmail = $playerInvitation->email == Auth::user()->email ?? false;

        if ($isSameEmail) {
            if ($playerInvitation->player_id) {
                TeamPlayer::where('id', $playerInvitation->player_id)->update([
                    'user_id' => Auth::user()->id,
                ]);

                $playerInvitation->delete();
            }

            return response()->json(['success' => 'Convite aceito']);
        }

        return response()->json(['error' => 'Algum problema na veracidade da informação']);
    }

    public function refuse(Request $request): JsonResponse
    {
        $this->validate($request, [
            'invitationId' => 'required|int'
        ]);

        $data = $request->only([
            'invitationId'
        ]);

        $playerInvitation = PlayerInvitation::where('id', $data['invitationId'])->first();
        $isSameEmail = $playerInvitation->email == Auth::user()->email ?? false;

        if ($isSameEmail) {
            $playerInvitation->delete();
        }

        return response()->json(['success' => 'Convite recusado']);
    }
}
