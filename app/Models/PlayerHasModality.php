<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlayerHasModality extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $table = 'player_has_modality';

    public $fillable = [
        'player_id',
        'modality_id',
    ];

    public function modalityInfo(): HasOne
    {
        return $this->hasOne(Modality::class, 'id', 'modality_id');
    }
}
