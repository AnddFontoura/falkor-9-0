<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendlyGameOpponent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'friendly_game_opponents';

    protected $fillable = [
        'opponent_id',
        'selected'
    ];
}
