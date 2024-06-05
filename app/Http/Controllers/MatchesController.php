<?php

namespace App\Http\Controllers;

use App\Http\Service\MatchHasPlayerService;
use App\Models\City;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    protected string $viewFolder = 'system.matches.';
    protected string $saveRedirect = 'system/matches';
    protected Matches $model;
    protected matchHasPlayerService $matchHasPlayerService;

    function __construct(Matches $model, matchHasPlayerService $matchHasPlayerService)
    {
        $this->model = $model;
        $this->matchHasPlayerService = $matchHasPlayerService;
        parent::__construct();
    }

    public function index(Request $request, int $teamId)
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

        $cities = $this->model
            ->where('created_by_team_id', $teamId)
            ->distinct('city_id');

        $matches = $this->model
            ->where('created_by_team_id', $teamId)
            ->orderby('schedule', 'desc');

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

        return view($this->viewFolder . 'index', compact('matches', 'cities', 'teamId'));
    }

    public function list(Request $request)
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

        $cities = City::get();

        $matches = $this->model->orderby('schedule', 'desc');

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

        return view($this->viewFolder . 'index_wt', compact('matches', 'cities'));
    }

    public function form(int $teamId, int $matchId = null)
    {
        $match = null;

        $cities = $this->cityModel
            ->orderBy('name', 'asc')
            ->get();

        if ($matchId) {
            $match = $this->model->where('id', $matchId)->first();
        }

        return view($this->viewFolder . 'form', compact('teamId', 'match', 'cities'));
    }

    public function store(Request $request, int $teamId, int $matchId = null)
    {
        $this->validate($request, [
            'myTeamIs' => 'required|int',
            'enemyTeamId' => 'nullable|int',
            'enemyTeamName' => 'nullable|string',
            'championshipName' => 'nullable|string',
            'cityId' => 'required|int',
            'matchLocation' => 'required|string|min:1|max:1000',
            'myTeamScore' => 'nullable|int',
            'enemyTeamScore' => 'nullable|int',
            'matchSchedule' => 'required|date',
        ]);

        $data = $request->only([
            'myTeamIs',
            'enemyTeamId',
            'enemyTeamName',
            'championshipName',
            'cityId',
            'matchLocation',
            'myTeamScore',
            'enemyTeamScore',
            'matchSchedule',
        ]);

        if ($data['myTeamIs'] == 1) {
            //Home
            $homeTeamId = $teamId;
            $homeTeamName = Team::where('id', $teamId)->first()->name;
            $homeTeamScore = $data['myTeamScore'];
            $visitorTeamId = $data['enemyTeamId'] ?? null;
            $visitorTeamName = $data['enemyTeamName'] ?? null;
            $visitorTeamScore = $data['enemyTeamScore'] ?? null;
        } else {
            //Visitor
            $visitorTeamId = $teamId;
            $visitorTeamName = Team::where('id', $teamId)->first()->name;
            $visitorTeamScore = $data['myTeamScore'];
            $homeTeamId = $data['enemyTeamId'] ?? null;
            $homeTeamName = $data['enemyTeamName'] ?? null;
            $homeTeamScore = $data['enemyTeamScore'] ?? null;
        }

        if ($matchId) {
            $this->model->where('id', $matchId)
            ->update([
                'created_by_team_id' => $teamId,
                'championship_id' => null,
                'visitor_team_id' => $visitorTeamId,
                'home_team_id' => $homeTeamId,
                'field_id' => null,
                'city_id' => $data['cityId'],
                'championship_name' => $data['championshipName'],
                'visitor_team_name' => $visitorTeamName,
                'home_team_name' => $homeTeamName,
                'visitor_score' => $visitorTeamScore,
                'home_score' => $homeTeamScore,
                'location' => $data['matchLocation'],
                'schedule' => $data['matchSchedule'],
            ]);

            $match = $this->model->where('id', $matchId)
                ->first();

            $message = "Partida atualizada com sucesso";
        } else {
            $match = $this->model->create([
                'created_by_team_id' => $teamId,
                'championship_id' => null,
                'visitor_team_id' => $visitorTeamId,
                'home_team_id' => $homeTeamId,
                'field_id' => null,
                'city_id' => $data['cityId'],
                'championship_name' => $data['championshipName'],
                'visitor_team_name' => $visitorTeamName,
                'home_team_name' => $homeTeamName,
                'visitor_score' => $visitorTeamScore,
                'home_score' => $homeTeamScore,
                'location' => $data['matchLocation'],
                'schedule' => $data['matchSchedule'],
            ]);

            $message = "Partida criada com sucesso";
        }

        $this->matchHasPlayerService->fillPlayersOnMatch($match, $teamId);

        return redirect($this->saveRedirect . '/' . $teamId)->with('success', $message);
    }

    public function show(int $teamId, int $matchId)
    {
        $match = $this->model->where('id', $matchId)->first();

        $visitorTeamPlayers = null;
        $homeTeamPlayers = null;

        if ($match->visitor_team_id) {
            $visitorTeamPlayers = $this->matchHasPlayerService->getPlayersOnMatch($matchId, $match->visitor_team_id);
        }

        if ($match->home_team_id) {
            $homeTeamPlayers = $this->matchHasPlayerService->getPlayersOnMatch($matchId, $match->home_team_id);
        }

        if (!$match) {
            return redirect($this->saveRedirect . '/' . $teamId)->with(['error' => 'Nenhuma partida encontrada']);
        }

        return view($this->viewFolder . 'show', compact('match', 'teamId', 'homeTeamPlayers', 'visitorTeamPlayers'));
    }

    public function view(int $matchId)
    {
        $match = $this->model->where('id', $matchId)->first();
        $visitorTeamPlayers = null;
        $homeTeamPlayers = null;

        if ($match->visitor_team_id) {
            $visitorTeamPlayers = $this->matchHasPlayerService->getPlayersOnMatch($matchId, $match->visitor_team_id);
        }

        if ($match->home_team_id) {
            $homeTeamPlayers = $this->matchHasPlayerService->getPlayersOnMatch($matchId, $match->home_team_id);
        }

        if (!$match) {
            return redirect('system/matches')->with(['error' => 'Nenhuma partida encontrada']);
        }

        return view($this->viewFolder . 'view', compact('match', 'homeTeamPlayers', 'visitorTeamPlayers'));
    }
}
