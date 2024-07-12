<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamApplication extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'user_id',
        'game_position_id',
        'team_id',
        'approved',
        'rejection_reason'
    ];
}
