<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Models\Player;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected string $viewFolder = 'system.admin.';
    protected string $saveRedirect = 'admin';

    public function index()
    {
        $registeredUsers = User::count('id');
        $registeredTeams = Team::count('id');
        $registeredProfiles = Player::where('status', 1)->count('id');
        $registeredMatches = Matches::count('id');

        return view($this->viewFolder . 'dashboard',
            compact(
                'registeredUsers',
                'registeredTeams',
                'registeredProfiles',
                'registeredMatches'
            )
        );
    }
}
