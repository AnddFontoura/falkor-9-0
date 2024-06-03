<?php

namespace App\Http\Controllers;

use App\Models\PlayerInvitation;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Player;

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

        /**
         * Plan
         */
        $userPlan = $this->userModel->userPlanInfo()->first();
        //dd($userPlan);
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
        $isPlayerInOwnedTeam = null;

        /**
         * Team Player
         */
        $teamsPlayer = $this->userModel->teamPlayerInfo()->get();
        $teamsId = array();

        // foreach($teamPlayer as $team) {
        //     array_push($teamsId, $team->team_id);
        // }

        return view('home', compact('playerInvitations', 'planInfo', 'planFinishDate', 'ownedTeams', 'teamsPlayer'));
    }
}
