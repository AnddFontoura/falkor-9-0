<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendlyGameOpponent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'friendly_game_opponents';

    protected $fillable = [
        'friendly_game_id',
        'opponent_id',
        'selected',
        'main_uniform_color',
        'secondary_uniform_color',
    ];

    public function friendlyGameInfo(): HasOne
    {
        return $this->hasOne(
            FriendlyGame::class,
            'id',
            'friendly_game_id'
        );
    }

    public function opponentInfo(): HasOne
    {
        return $this->hasOne(
            Team::class,
            'id',
            'opponent_id'
        );
    }
}
