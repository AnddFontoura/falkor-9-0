<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamSearchPosition extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'team_id',
        'game_position_id'
    ];

    public function gamePositionInfo(): hasOne
    {
        return $this->hasOne(
            GamePosition::class,
            'id',
            'game_position_id'
        );
    }
}
