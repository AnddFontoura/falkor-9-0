<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\GamePosition;
use App\Models\Player;
use App\Models\State;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    protected string $viewFolder = 'system.player.';
    protected string $saveRedirect = 'system/player';
    protected $model;

    function __construct(Player $model)
    {
        $this->model = $model;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->validate($request, [
            'playerName' => 'nullable|string|min:5|max:254',
            'cityId' => 'nullable|int',
            'stateId' => 'nullable|int',
            'playerPosition' => 'nullable|array'
        ]);

        $filter = $request->only([
            'playerName',
            'cityId',
            'stateId',
            'playerPosition',
        ]);

        $gamePositions = GamePosition::get();
        $cities = City::get();
        $states = State::get();
        $players = Player::where('status', true)
            ->orderBy('name', 'asc');

        if (isset($filter['playerName']) && $filter['playerName']) {
            $players = $players->where('name', 'like' , '%' . $filter['playerName'] . '%');
        }

        if (isset($filter['cityId']) && $filter['cityId']) {
            $players = $players->where('name', $filter['cityId']);
        }

        if (isset($filter['stateId']) && $filter['stateId']) {
            $players = $players->join('states', 'states.id', '=' , 'players.state_id')
                ->where('players.state_id', $filter['stateId']);
        }

        if (isset($filter['playerPosition']) && $filter['playerPosition']) {
            $players = $players->whereIn('game_position_id', $filter['playerPosition']);
        }

        $players = $players->paginate();

        return view($this->viewFolder . 'index', 
            compact(
                'states',
                'cities',
                'gamePositions',
                'players'
            )
        );
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Player $player)
    {
        //
    }

    public function edit(Player $player)
    {
        //
    }

    public function update(Request $request, Player $player)
    {
        //
    }

    public function destroy(Player $player)
    {
        //
    }
}
