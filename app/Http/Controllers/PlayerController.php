<?php

namespace App\Http\Controllers;

use App\Enums\ShirtSizeEnum;
use App\Models\City;
use App\Models\GamePosition;
use App\Models\Player;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
            $players = $players->where('name', 'like', '%' . $filter['playerName'] . '%');
        }

        if (isset($filter['cityId']) && $filter['cityId']) {
            $players = $players->where('city_id', $filter['cityId']);
        }

        if (isset($filter['stateId']) && $filter['stateId']) {
            $players = $players->join('cities', 'cities.id', '=', 'players.city_id')
                ->join('states', 'states.id', '=', 'cities.state_id')
                ->where('cities.state_id', $filter['stateId']);
        }

        $players = $players->paginate();

        return view(
            $this->viewFolder . 'index',
            compact(
                'states',
                'cities',
                'gamePositions',
                'players'
            )
        );
    }

    public function form()
    {
        $gamePositions = GamePosition::orderBy('name')->get();
        $player = Player::where('user_id', Auth::user()->id)->first();
        $cities = City::orderBy('name')->get();
        $uniformSizes = ShirtSizeEnum::SHIRT_SIZE;

        return view($this->viewFolder . 'form', compact(
            'player',
            'gamePositions',
            'cities',
            'uniformSizes'
        ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'playerName' => 'required|string|min:1|max:250',
            'playerNickname' => 'nullable|string|min:1|max:250',
            'playerBirthdate' => 'required|date:Y-m-d',
            'playerCity' => 'nullable|int',
            'playerHeight' => 'required|int|min:50|max:250',
            'playerWeight' => 'nullable|int|min:50|max:250',
            'playerFootSize' => 'nullable|int|min:12|max:50',
            'playerGloveSize' => 'nullable|int|min:6|max:12',
            'playerUniformSize' => 'nullable|string|min:1|max:3',
            'playerStatus' => 'required|boolean',
            'playerPhoto' => 'nullable|image',
        ]);

        $data = $request->only([
            'playerName',
            'playerNickname',
            'playerBirthdate',
            'playerCity',
            'playerHeight',
            'playerWeight',
            'playerFootSize',
            'playerGloveSize',
            'playerUniformSize',
            'playerStatus',
            'playerPhoto',
        ]);

        $user = Auth::user();

        $profile = Player::where('user_id', $user->id)->first();
        $photoPath = null;

        if (isset($data['playerPhoto'])) {
            $photoPath = $this->uploadService->uploadFileToFolder('public', 'profile_photos', $data['playerPhoto']);
        }

        if ($profile) {
            if ($photoPath) {
                if ($profile->photo) {
                    $this->uploadService->deleteFileOnFolder('public', 'profile_photos', $profile->photo);
                }
                $profile->photo = $photoPath;
                $profile->save();
            }

            $profile->city_id = $data['playerCity'];
            $profile->name = $data['playerName'];
            $profile->nickname = $data['playerNickname'];
            $profile->uniform_size = $data['playerUniformSize'];
            $profile->height = $data['playerHeight'];
            $profile->weight = $data['playerWeight'];
            $profile->foot_size = $data['playerFootSize'];
            $profile->glove_size = $data['playerGloveSize'];
            $profile->birthdate = $data['playerBirthdate'];
            $profile->status = $data['playerStatus'];
            $profile->save();

            return redirect('system/player/show/' . $profile->id);
        }

        $player = Player::create([
            'user_id' => $user->id,
            'city_id' => $data['playerCity'],
            'name' => $data['playerName'],
            'nickname' => $data['playerNickname'],
            'uniform_size' => $data['playerUniformSize'],
            'photo' => $photoPath,
            'height' => $data['playerHeight'],
            'weight' => $data['playerWeight'],
            'foot_size' => $data['playerFootSize'],
            'glove_size' => $data['playerGloveSize'],
            'birthdate' => $data['playerBirthdate'],
            'status' => $data['playerStatus']
        ]);

        return redirect('system/player/show/' . $player->id);
    }

    public function show(int $id)
    {
        $player = Player::where('id', $id)->first();

        if (!$player) {
            return redirect($this->saveRedirect)->with('error', 'Jogador não encontrado');
        }

        return view($this->viewFolder . 'show', compact('player'));
    }
}
