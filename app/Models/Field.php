<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\City;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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

    public function cityInfo(): BelongsTo
    {   
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
