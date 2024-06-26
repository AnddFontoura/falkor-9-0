<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
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

class TeamController extends Controller
{
    protected string $viewFolder = 'system.team.';
    protected string $saveRedirect = 'system/team';
    protected Team $model;

    public function __construct(Team $model)
    {
        $this->model = $model;
        parent::__construct();
    }

    public function index(Request $request): View
    {
        $this->validate($request, [
            'teamName' => 'nullable|string|min:1|max:254',
            'teamGender' => 'nullable|integer',
            'cityId' => 'nullable|integer',
            'stateId' => 'nullable|integer'
        ]);

        $filter = $request->only([
            'teamName',
            'teamGender',
            'cityId',
            'stateId',
        ]);

        $teams = $this->model->select('teams.*', 'team_players.id as playerId')
            ->leftJoin('team_players',  function($join) {
                $join->on('teams.id', '=', 'team_players.team_id')
                    ->where('team_players.user_id', '=', Auth::user()->id);
            });

        if(isset($filter['teamName']) && $filter['teamName']) {
            $teams = $teams->where('teams.name', 'like', '%' . $filter['teamName'] . '%');
        }

        if(isset($filter['cityId']) && $filter['cityId']) {
            $teams = $teams->where('teams.city_id', $filter['cityId']);
        }

        if(isset($filter['teamGender']) && $filter['teamGender'] >= 0) {
            $teams = $teams->where('teams.gender', $filter['teamGender']);
        }

        if(isset($filter['stateId']) && $filter['stateId']) {
            $teams = $teams
                ->join('cities', 'cities.id', '=', 'teams.city_id')
                ->where('cities.state_id', $filter['stateId']);
        }

        $teams = $teams->paginate();

        $cities = $this->cityModel->orderBy('name', 'asc')->get();
        $states = $this->stateModel->orderBy('name', 'asc')->get();
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;

        return view($this->viewFolder . 'index',
            compact(
                'teams',
                'cities',
                'states',
                'teamGender'
            )
        );
    }

    public function form(int $id = null): View
    {
        $team = null;
        $cities = $this->cityModel->orderBy('name', 'asc')->get();
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;

        if ($id) {
            $team = $this->model->where('id', $id)->first();
        }

        return view($this->viewFolder . 'form',
            compact(
                'team',
                'cities',
                'teamGender'
            )
        );
    }

    public function store(Request $request, int $id = null): Application|RedirectResponse|Redirector
    {
        $this->validate($request, [
            'cityId' => 'required|integer|min:1',
            'teamName' => 'required|string|min:1|max:254',
            'teamDescription' => 'required|string|min:1|max:10000',
            'teamGender' => 'required|integer',
            'foundationDate' => 'required|date:Y-m-d',
            'logo' => 'nullable|image',
            'banner' => 'nullable|image'
        ]);

        $data = $request->only([
            'cityId',
            'teamName',
            'teamGender',
            'teamDescription',
            'foundationDate',
            'logo',
            'banner',
        ]);

        $user = Auth()->user();
        $logoPath = null;
        $bannerPath = null;
        $message = "Você não é o dono do time para fazer essas alterações";
        $countTeams = $this->model->where('user_id', $user->id)->count('id');

        if (isset($data['logo'])) {
            $logoPath = $this->uploadService->uploadFileToFolder('public', 'logos', $data['logo']);
        }

        if (isset($data['banner'])) {
            $bannerPath = $this->uploadService->uploadFileToFolder('public', 'banners', $data['banner']);
        }

        if ($id) {
            $team = Team::where('id', $id)->first();

            if ($user->id != $team->user_id) {
                return redirect($this->saveRedirect)->with('error', $message);
            }

            if ($logoPath) {
                if($team->logo_path) {
                    $this->uploadService->deleteFileOnFolder('public', 'logos', $team->logo_path);
                }

                Team::where('id', $id)->update([
                    'logo_path' => $logoPath,
                ]);
            }

            if ($bannerPath) {
                if ($team->banner_path) {
                    $this->uploadService->deleteFileOnFolder('public', 'banners', $team->banner_path);
                }

                Team::where('id', $id)->update([
                    'banner_path' => $bannerPath,
                ]);
            }

            Team::where('id', $id)->update([
                'city_id' => $data['cityId'],
                'slug' => Str::slug($data['teamName']),
                'name' => $data['teamName'],
                'gender' => $data['teamGender'],
                'description' => $data['teamDescription'] ?? null,
                'foundation_date' => $data['foundationDate'] ?? null,
            ]);

            $message = "Time atualizado com sucesso";
        } else {
            if ($countTeams >= 3) {
                $message = "Você atingiu o limite de criação de times. Aumente seu plano para criar mais.";

                return redirect($this->saveRedirect)->with('error', $message);
            }

            Team::create([
                'user_id' => $user->id,
                'city_id' => $data['cityId'],
                'slug' => Str::slug($data['teamName'] . $data['cityId']),
                'name' => $data['teamName'],
                'gender' => $data['teamGender'],
                'description' => $data['teamDescription'] ?? null,
                'foundation_date' => $data['foundationDate'] ?? null,
                'logo_path' => $logoPath,
                'banner_path' => $bannerPath,
            ]);

            $message = "Time criado com sucesso";
        }

        return redirect($this->saveRedirect)->with('success', $message);
    }

    public function show(int $teamId): Application|RedirectResponse|Redirector|View
    {
        $team = $this->model->where('id', $teamId)->first();
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;

        if(!$team) {
            return redirect($this->saveRedirect)->with('error', 'Time não encontrado');
        }

        $teamPlayers = TeamPlayer::where('team_id', $team->id)
            ->where('active', true)
            ->orderBy('number', 'asc')
            ->get();

        return view($this->viewFolder . 'show',
            compact(
                'team',
                'teamPlayers',
                'teamGender',
            )
        );
    }

    public function manage(int $teamId): Application|RedirectResponse|Redirector|View
    {
        $today = new Carbon();
        $today = $today->format('Y-m-d');

        $team = $this->model->where('id', $teamId)->first();

        if(!$team) {
            return redirect($this->saveRedirect)->with('error', 'Time não encontrado');
        }

        $players = TeamPlayer::where('team_id', $teamId)->orderBy('number', 'asc')->get();

        $matches = Matches::where(function ($query) use ($teamId) {
            $query->where('visitor_team_id', $teamId)
                ->orWhere('home_team_id', $teamId);
        })
            ->where('schedule', '>=', $today)
            ->limit(5)
            ->get();

        return view($this->viewFolder . 'manage', compact('team', 'players', 'matches'));
    }

    public function matches(Request $request, int $teamId): View
    {
        $this->validate($request,[
            'matchEnemyTeamName' => 'nullable|string|min:3',
            'matchScheduleStartsIn' => 'nullable|date',
            'matchScheduleEndsIn' => 'nullable|date',
        ]);

        $team = Team::where('id', $teamId)->first();

        $matches = Matches::where(function ($query) use ($teamId) {
            $query->where('visitor_team_id', $teamId)
                ->orWhere('home_team_id', $teamId);
        })
            ->orderBy('schedule', 'desc')
            ->paginate();

        return view($this->viewFolder . 'matches',
            compact(
                'matches',
                'team'
            )
        );
    }
}
