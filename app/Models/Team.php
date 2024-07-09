<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'city_id',
        'modality_id',
        'slug',
        'name',
        'description',
        'foundation_date',
        'logo_path',
        'banner_path',
        'gender',
        'allow_application'
    ];

    public function cityInfo(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function modalityInfo(): HasOne
    {
        return $this->hasOne(Modality::class, 'id', 'modality_id');
    }
}
