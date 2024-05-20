<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'main',
        'photo'
    ];

    public function rulesForNewPhotos(): array
    {
        return [
            'photos' => 'required|array',
            'photos.*' => 'required|image|mimes:png,jpeg'
        ];
    }
}
