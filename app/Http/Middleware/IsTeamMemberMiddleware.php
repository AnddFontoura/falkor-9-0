<?php

namespace App\Http\Middleware;

use App\Models\Team;
use App\Models\TeamPlayer;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsTeamMemberMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $teamId = $request->teamId;
        $team = Team::where('id', $teamId)->first();
        $teamHasPlayer = TeamPlayer::where('team_id', $teamId)->where('user_id', Auth::id())->first();

        if (!$teamHasPlayer) {
            return redirect(RouteServiceProvider::HOME)->with('error', 'Você não tem permissão para acessar essa url');
        }

        return $next($request);
    }
}
