<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSawNews extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_saw_news';

    protected $fillable = [
      'user_id',
      'news_id'
    ];
}
