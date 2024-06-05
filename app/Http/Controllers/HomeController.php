<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\MatchHasPlayer;
use App\Models\Plan;
use App\Models\PlayerInvitation;
use App\Models\Team;
use App\Models\TeamPlayer;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    public function index(): View
    {
        $user = Auth::user();

        $playerInvitations = PlayerInvitation::where('email', $user->email)
            ->get();

        $ownedTeams = Team::where('user_id', $user->id)->get();

        $playerTeams = TeamPlayer::select('teams.*')
            ->join('teams', 'teams.id', 'team_players.team_id')
            ->where('team_players.user_id', $user->id)
            ->where('teams.user_id', '<>', $user->id)
            ->get();

        $userPlan = UserPlan::where('user_id', $user->id)->first();

        if ($userPlan) {
            $userPlan->expirationToHuman = $this->dateService->toHuman(
                Carbon::create($userPlan->finish_date)
            );
        }

        $nextMatches = Matches::select()
            ->join('match_has_players', 'match_has_players.match_id', 'matches.id')
            ->join('team_players', 'team_players.id', 'match_has_players.team_player_id')
            ->where('team_players.user_id', $user->id)
            ->whereRaw('matches.schedule >= NOW()')
            ->orderBy('matches.schedule')
            ->limit(5)
            ->get();

        return view('home',
            compact(
                'playerInvitations',
                'ownedTeams',
                'playerTeams',
                'nextMatches',
                'userPlan'
            )
        );
    }
}
