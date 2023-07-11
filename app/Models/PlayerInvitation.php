<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerInvitation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'team_player_id',
        'user_id',
        'team_id',
        'email',
    ];

    
    public function teamInfo(): HasOne
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function userInfo(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function teamPlayerInfo(): HasOne
    {
        return $this->hasOne(TeamPlayer::class, 'id', 'game_position_id');
    }
}
