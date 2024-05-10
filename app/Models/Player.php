<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'city_id',
        'name',
        'nickname',
        'uniform_size',
        'photo',
        'height',
        'weight',
        'foot_size',
        'glove_size',
        'birthdate',
        'status'
    ];
    
    public function cityInfo(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function userInfo(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
