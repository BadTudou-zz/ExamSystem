<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'lecture_user', 'user_id', 'lecture_id');
    }
}
