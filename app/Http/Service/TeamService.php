<?php

namespace App\Http\Service;

use App\Models\Team;
use App\Models\TeamPlayer;
use Illuminate\Support\Facades\Auth;

class TeamService extends BaseService
{
    protected $model;
    public function __construct()
    {
        $this->model = new Team();
    }

    public function filterTeams(array $filter)
    {
        $loggedUser = Auth::user();

        $teams = $this->model::select('teams.*');

        if($loggedUser) {
            $teams->select('team_players.id as playerId')
                ->leftJoin('team_players', function ($join) use ($loggedUser) {
                $join->on('teams.id', '=', 'team_players.team_id')
                    ->where('team_players.user_id', '=', $loggedUser->id);
            });
        }

        if (isset($filter['teamName']) && $filter['teamName']) {
            $teams->where('teams.name', 'like', '%' . $filter['teamName'] . '%');
        }

        if (isset($filter['cityId']) && $filter['cityId']) {
            $teams->where('teams.city_id', $filter['cityId']);
        }

        if (isset($filter['teamGender']) && $filter['teamGender'] >= 0) {
            $teams->where('teams.gender', $filter['teamGender']);
        }

        if (isset($filter['modalityId']) && $filter['modalityId'] >= 0) {
            $teams->where('teams.modality_id', $filter['modalityId']);
        }

        if (isset($filter['allowApplication']) && $filter['allowApplication']) {
            $teams->where(
                'teams.allow_application',
                true
            );
        }

        if (isset($filter['stateId']) && $filter['stateId']) {
            $teams
                ->join('cities', 'cities.id', '=', 'teams.city_id')
                ->where('cities.state_id', $filter['stateId']);
        }

        return $teams->paginate();
    }

    public function updateWhereId(int $teamId, array $data)
    {
        $this->model->where('id', $teamId)->update($data);
    }

    public function userBelongsToTeam(int $userId, $teamId): bool
    {
        return (bool) TeamPlayer::where('user_id', $userId)
            ->where('team_id', $teamId)
            ->first();
    }
}
