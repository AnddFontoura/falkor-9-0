<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\ShirtSizeEnum;
use App\Models\City;
use App\Models\GamePosition;
use App\Models\Modality;
use App\Models\Player;
use App\Models\PlayerHasGamePosition;
use App\Models\PlayerHasModality;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'playerGender' => 'nullable|int',
            'playerGamePositions' => 'nullable|array',
            'playerModalities' => 'nullable|array',
        ]);

        $filter = $request->only([
            'playerName',
            'cityId',
            'stateId',
            'playerGender',
            'playerGamePositions',
            'playerModalities',
        ]);

        $gamePositions = GamePosition::get();
        $genderArray = GenderEnum::GENDER_PLAYER_ARRAY;
        $cities = City::get();
        $states = State::get();
        $modalities = Modality::get();

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

        if (isset($filter['playerModalities']) && $filter['playerModalities']) {
            $players = $players->join('player_has_modality', 'player_has_modality.player_id', '=', 'players.id')
                ->whereIn('player_has_modality.modality_id', $filter['playerModalities'])
                ->whereNull('player_has_modality.deleted_at');
        }

        $players = $players->paginate();

        $players = $this->getGamePositionsForUser($players);

        return view(
            $this->viewFolder . 'index',
            compact(
                'states',
                'cities',
                'modalities',
                'gamePositions',
                'players',
                'genderArray'
            )
        );
    }

    public function form()
    {
        $genderArray = GenderEnum::GENDER_PLAYER_ARRAY;

        $gamePositions = GamePosition::orderBy('name')
            ->get();

        $player = Player::where('user_id', Auth::user()->id)
            ->first();

        if ($player) {
            $player->gamePositions = PlayerHasGamePosition::where('player_id', $player->id)
                ->pluck('game_position_id')
                ->toArray();

            $player->modalities = PlayerHasModality::where('player_id', $player->id)
                ->pluck('modality_id')
                ->toArray();
        }

        $cities = City::orderBy('name')
            ->get();

        $modalities = Modality::orderBy('id', 'asc')
            ->get();

        $uniformSizes = ShirtSizeEnum::SHIRT_SIZE;

        return view($this->viewFolder . 'form', compact(
            'player',
            'gamePositions',
            'cities',
            'modalities',
            'uniformSizes',
            'genderArray'
        ));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'playerGamePositions' => 'nullable|array',
            'playerModalities' => 'nullable|array',
            'playerName' => 'required|string|min:1|max:250',
            'playerNickname' => 'nullable|string|min:1|max:250',
            'playerBirthdate' => 'required|date:Y-m-d',
            'playerCity' => 'nullable|int',
            'playerBirthCity' => 'nullable|int',
            'playerHeight' => 'required|int|min:50|max:250',
            'playerWeight' => 'nullable|int|min:50|max:250',
            'playerFootSize' => 'nullable|int|min:12|max:50',
            'playerGloveSize' => 'nullable|int|min:6|max:12',
            'playerGender' => 'nullable|int',
            'playerUniformSize' => 'nullable|string|min:1|max:3',
            'playerStatus' => 'required|boolean',
            'playerPhoto' => 'nullable|image',
            'playerFacebook' => 'nullable|string',
            'playerInstagram' => 'nullable|string',
            'playerX' => 'nullable|string',
            'playerTiktok' => 'nullable|string',
            'playerYoutube' => 'nullable|string',
            'playerKwai' => 'nullable|string',
            'playerGDA' => 'nullable|string',
        ]);

        $data = $request->only([
            'playerGamePositions',
            'playerModalities',
            'playerName',
            'playerNickname',
            'playerBirthdate',
            'playerCity',
            'playerBirthCity',
            'playerHeight',
            'playerWeight',
            'playerFootSize',
            'playerGloveSize',
            'playerGender',
            'playerUniformSize',
            'playerStatus',
            'playerPhoto',
            'playerFacebook',
            'playerInstagram',
            'playerX',
            'playerTiktok',
            'playerYoutube',
            'playerKwai',
            'playerGDA',
        ]);

        $user = Auth::user();

        $profile = Player::where('user_id', $user->id)->first();
        $photoPath = null;

        if (isset($data['playerPhoto'])) {
            $photoPath = $this->uploadService->uploadFileToFolder('public', 'profile_photos', $data['playerPhoto']);
        }

        $socialProfiles = [
            'facebook' => $data['playerFacebook'] ?? '',
            'instagram' => $data['playerInstagram'] ?? '',
            'x' => $data['playerX'] ?? '',
            'tiktok' => $data['playerTiktok'] ?? '',
            'youtube' => $data['playerYoutube'] ?? '',
            'kwai' => $data['playerKwai'] ?? '',
            'gda' => $data['playerGDA'] ?? '',
        ];

        if ($profile) {
            if ($photoPath) {
                if ($profile->photo) {
                    $this->uploadService->deleteFileOnFolder('public', 'profile_photos', $profile->photo);
                }
                $profile->photo = $photoPath;
                $profile->save();
            }

            $profile->city_id = $data['playerCity'];
            $profile->birth_city_id = $data['playerBirthCity'];
            $profile->name = $data['playerName'];
            $profile->nickname = $data['playerNickname'];
            $profile->uniform_size = $data['playerUniformSize'];
            $profile->height = $data['playerHeight'];
            $profile->weight = $data['playerWeight'];
            $profile->foot_size = $data['playerFootSize'];
            $profile->glove_size = $data['playerGloveSize'];
            $profile->birthdate = $data['playerBirthdate'];
            $profile->status = $data['playerStatus'];
            $profile->gender = $data['playerGender'];
            $profile->social_profiles = $socialProfiles;
            $profile->save();
        } else {
            $player = Player::create([
                'user_id' => $user->id,
                'city_id' => $data['playerCity'],
                'birth_city_id' => $data['playerBirthCity'],
                'name' => $data['playerName'],
                'nickname' => $data['playerNickname'],
                'uniform_size' => $data['playerUniformSize'],
                'photo' => $photoPath,
                'height' => $data['playerHeight'],
                'weight' => $data['playerWeight'],
                'foot_size' => $data['playerFootSize'],
                'glove_size' => $data['playerGloveSize'],
                'gender' => $data['playerGender'],
                'birthdate' => $data['playerBirthdate'],
                'status' => $data['playerStatus'],
                'social_profiles' => $socialProfiles,
            ]);
        }

        $profileId = $player->id ?? $profile->id;
        $this->updatePlayerGamePosition($data['playerGamePositions'], $profileId);
        $this->updateModalities($data['playerModalities'], $profileId);

        return redirect('system/player/show/' . $profileId);
    }

    public function show(int $id)
    {
        $user = Auth::user();
        $player = Player::where('id', $id)
            ->first();

        if (!$player) {
            return redirect($this->saveRedirect)->with('error', 'Jogador não encontrado');
        }

        $playerGamePosition = PlayerHasGamePosition::where('player_id', $player->id)
        ->pluck('game_position_id');

        $player->gamePositions = GamePosition::whereIn('id', $playerGamePosition)
            ->get();

        $playerModalities = PlayerHasModality::where('player_id', $player->id)
            ->pluck('modality_id');

        $player->modalities = Modality::whereIn('id', $playerModalities)
            ->get();

        if ($player->birthdate) {
            $player->age = Carbon::createFromDate($player->birthdate)->diffInYears();
        }

        return view($this->viewFolder . 'show',
            compact(
                'player',
                'user'
            )
        );
    }

    protected function updatePlayerGamePosition(array $gamePositions, int $playerId)
    {
        PlayerHasGamePosition::where('player_id', $playerId)
            ->delete();

        foreach ($gamePositions as $gamePosition) {
            $gpExists = PlayerHasGamePosition::where('game_position_id', $gamePosition)
                ->where('player_id', $playerId)
                ->withTrashed()
                ->first();

            if ($gpExists) {
                $gpExists->restore();
            } else {
                PlayerHasGamePosition::create([
                    'game_position_id' => $gamePosition,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    protected function updateModalities(array $modalities, int $playerId)
    {
        PlayerHasModality::where('player_id', $playerId)
            ->delete();

        foreach ($modalities as $modality) {
            $exists = PlayerHasModality::where('modality_id', $modality)
                ->where('player_id', $playerId)
                ->withTrashed()
                ->first();

            if ($exists) {
                $exists->restore();
            } else {
                PlayerHasModality::create([
                    'modality_id' => $modality,
                    'player_id' => $playerId,
                ]);
            }
        }
    }

    protected function getGamePositionsForUser($players)
    {
        foreach ($players as $player) {
            $playerGamePosition = PlayerHasGamePosition::where('player_id', $player->id)
                ->pluck('game_position_id');

            $player->gamePositions = GamePosition::whereIn('id', $playerGamePosition)
                ->get();
        }

        return $players;
    }

    protected function getModalitiesForUser($players)
    {
        foreach ($players as $player) {
            $playerModalities = PlayerHasModality::where('player_id', $player->id)
                ->pluck('game_position_id');

            $player->modalities = PlayerHasModality::whereIn('id', $playerModalities)
                ->get();
        }

        return $players;
    }
}
