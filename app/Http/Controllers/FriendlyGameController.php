<?php

namespace App\Http\Controllers;

use App\Http\Requests\FriendlyGameCreateOrUpdateRequest;
use App\Http\Requests\FriendlyGameFilterRequest;
use App\Models\FriendlyGame;
use Illuminate\Http\Request;
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
        ));
    }

    public function create(int $friendlyGameId): View
    {
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
