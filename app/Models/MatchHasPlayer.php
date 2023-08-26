<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchHasPlayer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'match_id',
        'team_player_id',
        'invited',
        'confirmed',
        'showed_up',
        'reason_for_absence',
        'price_payed',
    ];

    public function matchInfo(): HasOne
    {
        return $this->hasOne(Matches::class, 'id', 'match_id');
    }

    public function teamPlayerInfo(): HasOne
    {
        return $this->hasOne(TeamPlayer::class, 'id', 'team_player_id');
    }
}
