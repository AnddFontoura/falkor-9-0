<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\MatchHasPlayer;
use App\Models\PlayerInvitation;
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

        $teamsPlayer = $user->teamPlayerInfo()->get();

        /**
         * Plan
         */
        $userPlan = $user->userPlanInfo()->first();
        $planInfo = '';
        $planFinishDate = '';

        if ($userPlan != null) {
            $plan = $userPlan->plan()->get();
            $planInfo = $plan->where('id', $userPlan->plan_id)->first();
            $planFinishDate = $this->dateService->toHuman(
                Carbon::create($userPlan->finish_date)
            );
        }

        /**
         * Team owner
         */
        $ownedTeams = $user->teamsInfo()->get();
        $teamsPlayingIds = $teamsPlayer->pluck('team_id')->toArray();

        /**
         * Team Player
         */
        $ownedTeamsIds = $ownedTeams->pluck('id')->toArray();
        $filteredTeamsPlayer = $teamsPlayer->reject(function ($teamsPlaying) use ($ownedTeamsIds) {
            return in_array($teamsPlaying->team_id, $ownedTeamsIds);
        });

        /**
         * Upcoming matches
         */
        $currentDate = Carbon::now()->format('Y-m-d H:i:s');
        $nextMatches = Matches::select()
            ->join('match_has_players', 'match_has_players.match_id', 'matches.id')
            ->join('team_players', 'team_players.id', 'match_has_players.team_player_id')
            ->where('team_players.user_id', $user->id)
            ->where('matches.schedule', '>=', $currentDate)
            ->orderBy('matches.schedule')
            ->limit(5)
            ->get();

        return view('home',
            compact(
                'playerInvitations',
                'planInfo',
                'planFinishDate',
                'ownedTeams',
                'filteredTeamsPlayer',
                'teamsPlayingIds',
                'teamsPlayer',
                'nextMatches'
            )
        );
    }
}
