<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamPlayer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'user_id',
        'game_position_id',
        'active',
        'name',
        'nickname',
        'uniform_size',
        'photo',
        'number',
        'height',
        'weight',
        'foot_size',
        'glove_size',
        'birthdate',
    ];

    public function teamInfo(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function userInfo(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function gamePositionInfo(): HasOne
    {
        return $this->hasOne(GamePosition::class, 'id', 'game_position_id');
    }
}
