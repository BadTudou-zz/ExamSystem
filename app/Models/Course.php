<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function lectures()
    {
        return $this->belongsToMany('App\User', 'lectures', 'lecture_id', 'course_id');
    }
}
