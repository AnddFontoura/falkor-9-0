<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamModality extends Model
{
    use HasFactory;

    protected $table = 'team_modalities';

    protected $fillable = [
        'team_id',
        'modality_id'
    ];
}
