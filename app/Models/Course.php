<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'number', 'display_name', 'descripe'
    ];

    public function lectures()
    {
        return $this->belongsToMany('App\Lecture', 'lectures', 'course_id', 'lecture_id');
    }
}
