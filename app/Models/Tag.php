<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'title', 'creator_id', 'comment_id', 'user_id',
    ];
}
