<?php

namespace App\Http\Controllers;

use App\Enums\ShirtSizeEnum;
use App\Models\GamePosition;
use App\Models\Matches;
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

    public function index(Request $request, int $teamId): View
    {
        $this->validate($request, [
            'playerId' => 'nullable|integer',
            'playerName' => 'nullable|string|min:1|max:254',
            'playerNickName' => 'nullable|string|min:1|max:254',
            'gamePositionId' => 'nullable|integer',
            'playerNumber' => 'nullable|integer',
            'playerWithUser' => 'nullable|bool',
            'withDeleted' => 'nullable|bool',
        ]);

        $filter = $request->only([
            'playerId',
            'playerName',
            'playerNickName',
            'gamePositionId',
            'playerNumber',
            'playerWithUser',
            'withDeleted',
        ]);

        $players = $this->model->where('team_id', $teamId);

        if(isset($filter['playerName']) && $filter['playerName']) {
            $players = $players->where('name', 'like', '%' . $filter['playerName'] . '%');
        }

        if(isset($filter['playerNickName']) && $filter['playerNickName']) {
            $players = $players->where('nickname', 'like', '%' . $filter['playerNickName'] . '%');
        }

        if(isset($filter['gamePositionId']) && $filter['gamePositionId']) {
            $players = $players->where('game_position_id', $filter['gamePositionId']);
        }

        if(isset($filter['playerNumber']) && $filter['playerNumber']) {
            $players = $players->where('number', $filter['playerNumber']);
        }

        if(isset($filter['playerWithUser']) && $filter['playerWithUser']) {
            if ($filter['playerWithUser'] == 1) {
                $players = $players->whereNotNull('user_id');

            } else {
                $players = $players->whereNull('user_id');
            }
        }

        if(isset($filter['withDeleted']) && $filter['withDeleted'] == 1) {
            $players = $players->withTrashed();
        }

        $players = $players->orderBy('id', 'asc')
            ->orderBy('number', 'asc')
            ->paginate();

        $gamePositions = GamePosition::get();

        return view($this->viewFolder . 'index', compact('players', 'gamePositions', 'teamId'));
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

    public function dashboard(int $teamId)
    {
        $team = Team::where('id', $teamId)->first();
        $teamPlayerInfo = TeamPlayer::where('user_id', Auth::user()->id)->first();

        $matches = Matches::select('matches.*', 'match_has_players.confirmed')
            ->leftJoin('match_has_players',  function($join) use ($teamPlayerInfo) {
                $join->on('matches.id', '=', 'match_has_players.match_id')
                    ->where('match_has_players.team_player_id', '=', $teamPlayerInfo->id);
            })
            ->where('created_by_team_id', $teamId)
            ->where('schedule', '>=', Carbon::now()->format('Y-m-d h:i:s'))
            ->orderBy('schedule', 'DESC')
            ->get();

        return view($this->viewFolder . 'dashboard', compact('matches', 'team'));
    }
}
