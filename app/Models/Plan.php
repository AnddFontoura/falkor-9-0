<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'name',
        'description',
        'slug',
        'duration_days',
        'durations_months',
        'price',
        'features',
        'active',
    ];
}
