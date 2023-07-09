<?php

namespace App\Http\Controllers;

use App\Enums\ShirtSizeEnum;
use App\Models\GamePosition;
use App\Models\Team;
use App\Models\TeamPlayer;
use Carbon\Carbon;
use Illuminate\Console\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamPlayerController extends Controller
{
    protected string $viewFolder = 'system.team-player.';
    protected string $saveRedirect = 'system/team/manage';
    protected TeamPlayer $model;


    public function __construct(TeamPlayer $model)
    {
        $this->model = $model;
        parent::__construct();
    }

    public function index(Request $request): View
    {
        $this->validate($request, [
            'teamName' => 'nullable|string|min:1|max:254',
            'cityId' => 'nullable|integer',
            'stateId' => 'nullable|integer'
        ]);

        $filter = $request->only([
            'teamName',
            'cityId',
            'stateId',
        ]);

        $teams = $this->model->select();

        if(isset($filter['teamName']) && $filter['teamName']) {
            $teams = $teams->where('teams.name', 'like', '%' . $filter['teamName'] . '%');
        }

        if(isset($filter['cityId']) && $filter['cityId']) {
            $teams = $teams->where('teams.city_id', $filter['cityId']);
        }

        if(isset($filter['stateId']) && $filter['stateId']) {
            $teams = $teams
                ->join('cities', 'cities.id', '=', 'teams.city_id')
                ->where('cities.state_id', $filter['stateId']);
        }

        $teams = $teams->paginate();

        $cities = $this->cityModel->orderBy('name', 'asc')->get();
        $states = $this->stateModel->orderBy('name', 'asc')->get();

        return view($this->viewFolder . 'index', compact('teams', 'cities', 'states'));
    }

    public function form(int $teamId, int $playerId = null): View
    {
        $player = null;
        $gamePositions = GamePosition::get();
        $uniformSizes = ShirtSizeEnum::SHIRT_SIZE;

        if ($playerId) {
            $player = $this->model->where('id', $playerId)->first();
        }

        return view($this->viewFolder . 'form', compact('teamId', 'player', 'gamePositions', 'uniformSizes'));
    }

    public function store(Request $request, int $teamId, int $id = null): Application|RedirectResponse|Redirector
    {
        $this->validate($request, [
            'playerName' => 'required|string|min:1|max:254',
            'playerGamePosition' => 'required|int',
            'playerNickName' => 'nullable|string|min:1',
            'playerUniformSize' => 'nullable|string|min:1',
            'playerNumber' => 'nullable|int',
            'playerHeight' => 'nullable|int',
            'playerWeight' => 'nullable|int',
            'playerFootSize' => 'nullable|int',
            'playerGloveSize' => 'nullable|int',
            'playerBirthdate' => 'nullable|date:Y-m-d',
            'playerPhoto' => 'nullable|image'
        ]);

        $data = $request->only([
            'playerName',
            'playerGamePosition',
            'playerNickName',
            'playerUniformSize',
            'playerNumber',
            'playerHeight',
            'playerWeight',
            'playerFootSize',
            'playerGloveSize',
            'playerBirthdate',
            'playerPhoto',
        ]);

        $user = Auth::user();
        $photoPath = null;
        $message = "Você não é o dono do time para fazer essas alterações";

        if (isset($data['playerPhoto'])) {
            $photoPath = $this->uploadService->uploadFileToFolder('public', 'photos', $data['playerPhoto']);
        }

        if ($id) {

            $team = Team::where('id', $teamId)->first();
            $teamPlayer = TeamPlayer::where('id', $id)->first();

            if ($user->id != $team->user_id) {
                return redirect($this->saveRedirect)->with('error', $message);
            }

            if ($photoPath) {
                if ($teamPlayer->photo) {
                    $this->uploadService->deleteFileOnFolder('public', 'logos', $teamPlayer->photo);
                }

                TeamPlayer::where('id', $id)->update([
                    'photo' => $photoPath,
                ]);
            }

            TeamPlayer::where('id', $id)->update([
                'name' => $data['playerName'],
                'nickname' => $data['playerNickName'],
                'uniform_size' => $data['playerUniformSize'],
                'game_position_id' => $data['playerGamePosition'] ?? null,
                'number' => $data['playerNumber'] ?? null,
                'height' => $data['playerHeight'] ?? null,
                'weight' => $data['playerWeight'] ?? null,
                'foot_size' => $data['playerFootSize'],
                'glove_size' => $data['playerGloveSize'] ?? null,
                'birthdate' => $data['playerBirthdate'] ?? null,
            ]);

            $message = "Jogador atualizado com sucesso";
        } else {
            TeamPlayer::create([
                'team_id' => $teamId,
                'name' => $data['playerName'],
                'nickname' => $data['playerNickName'],
                'uniform_size' => $data['playerUniformSize'],
                'game_position_id' => $data['playerGamePosition'] ?? null,
                'number' => $data['playerNumber'] ?? null,
                'height' => $data['playerHeight'] ?? null,
                'weight' => $data['playerWeight'] ?? null,
                'foot_size' => $data['playerFootSize'],
                'glove_size' => $data['playerGloveSize'] ?? null,
                'birthdate' => $data['playerBirthdate'] ?? null,
            ]);

            $message = "Jogador criado com sucesso";
        }

        return redirect($this->saveRedirect . "/" . $teamId)->with('success', $message);
    }

    public function show(int $teamId, int $playerId): Application|RedirectResponse|Redirector|View
    {
        $player = $this->model->where('id', $playerId)->first();

        if(!$player) {
            return redirect($this->saveRedirect . "/" . $teamId)->with('error', 'Jogador não encontrado');
        }

        if ($player->birthdate) {
            $player->age = Carbon::createFromDate($player->birthdate)->diffInYears();
        }
        return view($this->viewFolder . 'show', compact('player', 'teamId'));
    }
}
