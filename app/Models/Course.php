<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'number', 'display_name', 'description'
    ];

    public function lectures()
    {
        return $this->belongsToMany('App\Lecture', 'lectures', 'lecture_id', 'course_id');
    }
}
