<?php

namespace App\Http\Middleware;

use App\Models\Team;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsTeamManagerMiddleware
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

        if ($team->user_id != Auth::id()) {
            return redirect(RouteServiceProvider::HOME)->with('error', 'Você não tem permissão para acessar essa url');
        }

        return $next($request);
    }
}
