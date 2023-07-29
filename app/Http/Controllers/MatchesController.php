<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\Team;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    protected string $viewFolder = 'system.matches.';
    protected string $saveRedirect = 'system/matches';
    protected Matches $model;

    function __construct(Matches $model)
    {
        $this->model = $model;
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

    public function store(Request $request, int $teamId)
    {
        $this->valdate($request, [
            'myTeamIs' => 'required|bool',
            'enemyTeamId' => 'nullable|int',
            'enemyTeamName' => 'nullable|string',
            'championshipName' => 'nullable|string',
            'cityId' => 'required|int',
            'matchLocation' => 'required|text|min:1|max:1000',
            'myTeamScore' => 'nullable|int',
            'enemyTeamScore' => 'nullable|int',
            'matchSchedule' => 'required|datetime',
        ]);

        $this->model->create([
            'created_by_team_id' => $teamId,
            'championship_id',
            'visitor_team_id',
            'home_team_id',
            'field_id',
            'city_id',
            'championship_name',
            'visitor_team_name',
            'home_team_name',
            'visitor_score',
            'home_score',
            'location',
            'schedule',
        ]);
    }

    public function show(int $teamId, int $matchId)
    {
        $match = $this->model->where('id', $matchId)->first();

        if (!$match) {
            return redirect($this->saveRedirect . '/' . $teamId)->with(['error' => 'Nenhuma partida encontrada']);
        }

        return view($this->viewFolder . 'view', compact('match'));
    }

    public function update(Request $request, Matches $matches)
    {
        //
    }

    public function destroy(Matches $matches)
    {
        //
    }
}
