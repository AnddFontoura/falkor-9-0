<?php

namespace App\Http\Controllers;

use App\Models\PlayerInvitation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        return view('home', compact('playerInvitations', 'planInfo', 'planFinishDate', 'ownedTeams', 'filteredTeamsPlayer', 'teamsPlayingIds', 'teamsPlayer'));
    }
}
