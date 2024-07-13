<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamApplication extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'player_id',
        'game_position_id',
        'team_id',
        'approved',
        'rejection_reason'
    ];

    public function playerInfo(): hasOne
    {
        return $this->hasOne(
            Player::class,
            'id',
            'player_id'
        );
    }

    public function gamePositionInfo(): HasOne
    {
        return $this->hasOne(
            GamePosition::class,
            'id',
            'game_position_id'
        );
    }

    public function teamInfo(): HasOne
    {
        return $this->hasOne(
            Team::class,
            'id',
            'team_id'
        );
    }
}
