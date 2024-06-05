<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\MatchHasPlayer;
use App\Models\PlayerInvitation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    protected $userModel;
    protected $plan;
    protected $dashboardService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $playerInvitations = PlayerInvitation::where('email', Auth::user()->email)->get();
        $this->userModel = User::find(Auth::user()->id);
        $teamsPlayer = $this->userModel->teamPlayerInfo()->get();

        /**
         * Plan
         */
        $userPlan = $this->userModel->userPlanInfo()->first();
        $planInfo = '';
        $planFinishDate = '';

        if ($userPlan != null) {
            $plan = $userPlan->plan()->get();
            $planInfo = $plan->where('id', $userPlan->plan_id)->first();
            $planFinishDate = $this->dateService->getPlanFinishDate($userPlan);
        }

        /**
         * Team owner
         */
        $ownedTeams = $this->userModel->teamsInfo()->get();
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
            ->where('team_players.user_id', $this->userModel->id)
            ->where('matches.schedule', '>=', $currentDate)
            ->orderBy('matches.schedule')
            ->limit(5)
            ->get();

        return view('home', compact('playerInvitations', 'planInfo', 'planFinishDate', 'ownedTeams', 'filteredTeamsPlayer', 'teamsPlayingIds', 'teamsPlayer', 'nextMatches'));
    }
}