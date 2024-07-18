<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Http\Requests\FriendlyGameCreateOrUpdateRequest;
use App\Http\Requests\FriendlyGameFilterRequest;
use App\Http\Service\ModalityService;
use App\Models\FriendlyGame;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class FriendlyGameController extends Controller
{
    public string $viewFolder = 'system.friendly-game.';
    public function index(FriendlyGameFilterRequest $request): View
    {
        $filter = $request->validated();

        $cities = $this->cityService->getOrderedByName();
        $states = $this->stateService->getOrderedByName();
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;
        $modalities = $this->modalityService->getOrderedByName();

        $friendlyGames = FriendlyGame::select('friendly_game.*');

        if (isset($filter['matchCityId'])) {
            $friendlyGames = $friendlyGames->where(
                'city_id',
                $filter['matchCityId']
            );
        }

        $friendlyGames = $friendlyGames->paginate();

        return view($this->viewFolder . 'index', compact(
            'friendlyGames',
            'cities',
            'states',
            'teamGender',
            'modalities'
        ));
    }

    public function form(int $friendlyGameId = null): View
    {
        $friendlyGame = null;
        $user = Auth::user();

        $ownedTeams = Team::where('user_id', $user->id)
            ->orderBy('name', 'asc')
            ->get();
        $cities = $this->cityService->getOrderedByName();

        if ($friendlyGameId) {
            $friendlyGame = FriendlyGame::where('id', $friendlyGameId)
                ->first();
        }

        return view($this->viewFolder . 'form',
            compact(
                'cities',
                'friendlyGame',
                'ownedTeams',
            )
        );
    }

    public function store(FriendlyGameCreateOrUpdateRequest $request)
    {
        return redirect();
    }

    public function show($id): View
    {
        return view();
    }
}
