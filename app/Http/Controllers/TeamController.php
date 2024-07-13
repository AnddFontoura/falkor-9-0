<?php

namespace App\Http\Controllers;

use App\Enums\GenderEnum;
use App\Enums\PlanEnum;
use App\Http\Requests\TeamCreateOrUpdateRequest;
use App\Http\Requests\TeamFilterRequest;
use App\Http\Service\ModalityService;
use App\Http\Service\TeamService;
use App\Models\GamePosition;
use App\Models\Matches;
use App\Models\Modality;
use App\Models\Team;
use App\Models\TeamApplication;
use App\Models\TeamPlayer;
use App\Models\TeamSearchPosition;
use App\Models\UserPlan;
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

    protected TeamService $teamService;

    protected ModalityService $modalityService;

    public function __construct(Team $model)
    {
        $this->model = $model;
        $this->teamService = new TeamService();
        $this->modalityService = new ModalityService();
        parent::__construct();
    }

    public function index(TeamFilterRequest $request): View
    {
        $filter = $request->only([
            'teamName',
            'teamGender',
            'cityId',
            'stateId',
            'modalityId',
            'allowApplication',
        ]);

        $teams = $this->teamService->filterTeams($filter);
        $cities = $this->cityService->getOrderedByName();
        $states = $this->stateService->getOrderedByName();
        $modalities = $this->modalityService->getOrderedById();
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;

        return view($this->viewFolder . 'index',
            compact(
                'teams',
                'cities',
                'states',
                'teamGender',
                'modalities'
            )
        );
    }

    public function form(int $id = null): View
    {
        $team = null;
        $cities = $this->cityService->getOrderedByName();
        $modalities = $this->modalityService->getOrderedById();
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;

        if ($id) {
            $team = $this->teamService->getById($id);
        }

        return view($this->viewFolder . 'form',
            compact(
                'team',
                'cities',
                'modalities',
                'teamGender',
            )
        );
    }

    public function store(TeamCreateOrUpdateRequest $request, int $id = null): Application|RedirectResponse|Redirector
    {
        $data = $request->only([
            'cityId',
            'teamName',
            'teamGender',
            'modalityId',
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
            $team = $this->teamService->getById($id);

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
                'modality_id' => $data['modalityId'],
                'slug' => Str::slug($data['teamName']),
                'name' => $data['teamName'],
                'gender' => $data['teamGender'],
                'description' => $data['teamDescription'] ?? null,
                'foundation_date' => $data['foundationDate'] ?? null,
            ]);

            $userPlan = UserPlan::where('user_id', $user->id)
                ->where('start_date', '<=', Carbon::now()->format('Y-m-d H:i:s'))
                ->where('finish_date', '>=', Carbon::now()->format('Y-m-d H:i:s'))
                ->first();

            if ($userPlan->id !== PlanEnum::BASIC_PLAN) {
                Team::where('id', $id)->update([
                    'modality_id' => $data['modalityId'],
                ]);
            }

            $message = "Time atualizado com sucesso";
        } else {
            if ($countTeams >= 3) {
                $message = "Você atingiu o limite de criação de times. Aumente seu plano para criar mais.";

                return redirect($this->saveRedirect)->with('error', $message);
            }

            $team = Team::create([
                'user_id' => $user->id,
                'city_id' => $data['cityId'],
                'modality_id' => $data['modalityId'],
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
        $team = $this->teamService->getById($teamId);
        $teamGender = GenderEnum::GENDER_TEAM_ARRAY;
        $teamSearchPositions = TeamSearchPosition::where('team_id', $teamId)->get();

        if(!$team) {
            return redirect($this->saveRedirect)->with('error', 'Time não encontrado');
        }

        $teamPlayers = TeamPlayer::select('team_players.*', 'players.id as profile_id')
            ->where('team_id', $team->id)
            ->leftJoin('players', 'team_players.user_id', '=', 'players.user_id')
            ->where('active', true)
            ->orderBy('number', 'asc')
            ->get();

        $userBelongsToTeam = $this->teamService
            ->userBelongsToTeam(Auth::user()->id, $teamId);

        return view($this->viewFolder . 'show',
            compact(
                'team',
                'teamPlayers',
                'teamGender',
                'teamSearchPositions',
                'userBelongsToTeam'
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

        $team = $this->teamService->getById($teamId);

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

    public function searchPositions(int $teamId): View
    {
        $team = $this->teamService->getById($teamId);
        $teamSearchPositions = TeamSearchPosition::where('team_id', $teamId)
            ->pluck('game_position_id')
            ->toArray();
        $gamePositions = GamePosition::get();

        return view('system.search-player.form',
            compact(
                'team',
                'teamSearchPositions',
                'gamePositions'
            )
        );
    }

    public function playersApplications(Request $request, int $teamId)
    {
        $team = $this->teamService->getById($teamId);
        $gamePositions = GamePosition::get();
        $cities = $this->cityService->getOrderedByName();
        $states = $this->stateService->getOrderedByName();

        $this->validate($request, [
            'applicationName' => 'nullable|string|min:3'
        ]);

        $filter = $request->only([
            'applicationName'
        ]);

        $teamApplications = TeamApplication::join(
            'players',
            'players.id',
            '=',
            'team_applications.player_id'
        );

        if (isset($filter['applicationName'])) {
            $teamApplications = $teamApplications->where(
                'players.name',
                'like',
                '%' . $filter['applicationName'] . '%'
            );
        }

        $teamApplications = $teamApplications
            ->whereNull('team_applications.approved')
            ->orderBy('team_applications.created_at', 'asc')
            ->paginate();

        return view($this->viewFolder . 'player_applications',
            compact(
                'teamApplications',
                'team',
                'cities',
                'states',
                'gamePositions',
            )
        );

    }
}
