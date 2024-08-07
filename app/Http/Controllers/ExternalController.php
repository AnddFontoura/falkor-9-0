<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Http\Requests\TeamFilterRequest;
use App\Http\Service\TeamService;
use App\Models\City;
use App\Models\GamePosition;
use App\Models\Matches;
use App\Models\Player;
use App\Models\State;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExternalController extends Controller
{
    protected TeamService $teamService;

    public function __construct(Team $model)
    {
        $this->teamService = new TeamService();
        parent::__construct();
    }
    public function index(): View
    {
        return view('external.home');
    }

    public function teams(TeamFilterRequest $request): View
    {
        $filter = $request->only([
            'teamName',
            'teamGender',
            'cityId',
            'stateId',
        ]);

        $teams = $this->teamService->filterTeams($filter);

        $cities = $this->cityService->getOrderedByName();
        $states = $this->stateService->getOrderedByName();
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;

        return view('external.teams',
            compact(
                'teams',
                'cities',
                'states',
                'teamGender'
            )
        );
    }

    public function players(Request $request): View
    {
        $this->validate($request, [
            'playerName' => 'nullable|string|min:5|max:254',
            'cityId' => 'nullable|int',
            'stateId' => 'nullable|int',
            'playerGender' => 'nullable|int',
            'playerGamePositions' => 'nullable|array'
        ]);

        $filter = $request->only([
            'playerName',
            'cityId',
            'stateId',
            'playerGender',
            'playerGamePositions',
        ]);

        $gamePositions = GamePosition::get();
        $genderArray = GenderEnum::GENDER_PLAYER_ARRAY;
        $cities = City::get();
        $states = State::get();
        $players = Player::select('players.*')
            ->where('status', true)
            ->orderBy('name', 'asc');

        if (isset($filter['playerName']) && $filter['playerName']) {
            $players = $players->where('players.name', 'like', '%' . $filter['playerName'] . '%');
        }

        if (isset($filter['cityId']) && $filter['cityId']) {
            $players = $players->where('players.city_id', $filter['cityId']);
        }

        if (isset($filter['playerGender']) && $filter['playerGender'] != 0) {
            $players = $players->where('players.gender', $filter['playerGender']);
        }

        if (isset($filter['stateId']) && $filter['stateId']) {
            $players = $players->join('cities', 'cities.id', '=', 'players.city_id')
                ->join('states', 'states.id', '=', 'cities.state_id')
                ->where('cities.state_id', $filter['stateId']);
        }

        if (isset($filter['playerGamePositions']) && $filter['playerGamePositions']) {
            $players = $players->join('player_has_game_position', 'player_has_game_position.player_id', '=', 'players.id')
                ->whereIn('player_has_game_position.game_position_id', $filter['playerGamePositions'])
                ->whereNull('player_has_game_position.deleted_at');
        }

        $players = $players->paginate();

        return view('external.players',
            compact(
                'states',
                'cities',
                'gamePositions',
                'players',
                'genderArray'
            )
        );
    }

    public function matches(Request $request): View
    {
        $this->validate($request, [
            'scheduleStart' => 'nullable|date',
            'scheduleEnd' => 'nullable|date',
            'scheduleMonth' => 'nullable|int',
            'scheduleYear' => 'nullable|int',
        ]);

        $filter = $request->only([
            'scheduleStart',
            'scheduleEnd',
            'scheduleMonth',
            'scheduleYear',
        ]);

        $cities = $this->cityService->getOrderedByName();
        $states = $this->stateService->getOrderedByName();

        $matches = Matches::orderby('schedule', 'desc');

        if (isset($filter['scheduleStart']) && $filter['scheduleStart']) {
            if (isset($filter['scheduleEnd']) && $filter['scheduleEnd']) {
                $matches = $matches->whereBetween('schedule', [$filter['scheduleStart'], $filter['scheduleEnd']]);
            } else {
                $matches = $matches->where('schedule', '>=', $filter['scheduleStart']);
            }
        }

        if (isset($filter['scheduleEnd']) && $filter['scheduleEnd'] && !$filter['scheduleStart']) {
            $matches = $matches->where('schedule', '<=', $filter['scheduleEnd']);
        }

        if (isset($filter['scheduleMonth']) && $filter['scheduleMonth']) {
            $matches = $matches->whereMonth('schedule', $filter['scheduleMonth']);
        }

        if (isset($filter['scheduleYear']) && $filter['scheduleYear']) {
            $matches = $matches->whereYear('schedule', $filter['scheduleYear']);
        }

        $matches = $matches->paginate();

        return view('external.matches',
            compact(
            'matches',
                'cities',
                'states'
            )
        );
    }
}
