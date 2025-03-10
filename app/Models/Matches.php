<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matches extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "matches";

    protected $fillable = [
        'created_by_team_id',
        'championship_id',
        'visitor_team_id',
        'home_team_id',
        'field_id',
        'city_id',
        'championship_name',
        'visitor_team_name',
        'home_team_name',
        'visitor_score',
        'has_penalties',
        'visitor_penalty_score',
        'home_penalty_score',
        'home_score',
        'location',
        'schedule',
    ];

    protected $dates = [
        'schedule'
    ];

    public function homeTeamInfo(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'home_team_id');
    }

    public function visitorTeamInfo(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'visitor_team_id');
    }

    public function cityInfo(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
