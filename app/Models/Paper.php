<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $fillable = [
        'creator_id', 'title', 'score', 'min', 'describe', 'sections', 'tags'
    ];
}