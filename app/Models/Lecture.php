<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'name', 'user_id', 'course_id', 'allowable_organization_ids', 'allowable_user_ids', 'describe', 'max', 'current'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'lecture_user', 'lecture_id', 'user_id');
    }
}
