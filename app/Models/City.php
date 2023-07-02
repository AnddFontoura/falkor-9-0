<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'state_id',
        'name',
        'ibge_code',
    ];

    public function stateInfo(): HasOne
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }
}
