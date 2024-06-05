<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'finish_date',
        'is_trial',
        'features',
        'price',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function planInfo(): HasOne
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }
}
