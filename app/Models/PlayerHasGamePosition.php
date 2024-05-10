<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerHasGamePosition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'player_has_game_position';

    protected $fillable = [
        'player_id',
        'game_position_id',
    ];

    public function gamePositionInfo(): HasOne
    {
        return $this->hasOne(GamePosition::class, 'id', 'game_position_id');
    }
}
