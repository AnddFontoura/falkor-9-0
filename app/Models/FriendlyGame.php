<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class FriendlyGame extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'friendly_games';

    protected $fillable = [
        'team_id',
        'city_id',
        'description',
        'price',
        'match_date',
        'start_at',
        'duration',
        'defined',
        'main_uniform_color',
        'secondary_uniform_color',
    ];

    public $casts = [
        'match_date' => 'date',
    ];
    public function teamInfo(): hasOne
    {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function cityInfo(): hasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
}
