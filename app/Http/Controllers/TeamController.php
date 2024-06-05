<?php

namespace App\Http\Controllers;

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
            'cityId' => 'nullable|integer',
            'stateId' => 'nullable|integer'
        ]);

        $filter = $request->only([
            'teamName',
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

    public function form(int $id = null): View
    {
        $team = null;
        $cities = $this->cityModel->orderBy('name', 'asc')->get();

        if ($id) {
            $team = $this->model->where('id', $id)->first();
        }

        return view($this->viewFolder . 'form', compact('team', 'cities'));
    }

    public function store(Request $request, int $id = null): Application|RedirectResponse|Redirector
    {
        $this->validate($request, [
            'cityId' => 'required|integer|min:1',
            'teamName' => 'required|string|min:1|max:254',
            'teamDescription' => 'required|string|min:1|max:10000',
            'foundationDate' => 'required|date:Y-m-d',
            'logo' => 'nullable|image',
            'banner' => 'nullable|image'
        ]);

        $data = $request->only([
            'cityId',
            'teamName',
            'teamDescription',
            'foundationDate',
            'logo',
            'banner',
        ]);

        $user = Auth()->user();
        $logoPath = null;
        $bannerPath = null;
        $message = "Você não é o dono do time para fazer essas alterações";

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
                'description' => $data['teamDescription'] ?? null,
                'foundation_date' => $data['foundationDate'] ?? null,
            ]);

            $message = "Time atualizado com sucesso";
        } else {
            Team::create([
                'user_id' => $user->id,
                'city_id' => $data['cityId'],
                'slug' => Str::slug($data['teamName'] . $data['cityId']),
                'name' => $data['teamName'],
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

        if(!$team) {
            return redirect($this->saveRedirect)->with('error', 'Time não encontrado');
        }

        $teamPlayers = TeamPlayer::where('team_id', $team->id)
            ->where('active', true)
            ->orderBy('number', 'asc')
            ->get();

        return view($this->viewFolder . 'show', compact('team','teamPlayers'));
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
}
