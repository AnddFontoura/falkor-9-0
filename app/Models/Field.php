<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\City;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\FieldPhoto;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id',
        'name',
        'nickname',
        'address',
        'google_location',
    ];

    public function cityInfo(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(FieldPhoto::class);
    }
}
