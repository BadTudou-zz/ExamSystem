<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['creator_id', 'paper_id', 'title', 'exam_type', 'score', 'min', 'describe', 'allowable_lecture_ids', 'allowable_orgaization_ids', 'allowable_user_ids', 'begin_at', 'start_at', 'finish_at'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'exam_user', 'exam_id', 'user_id')->withTimestamps()->withPivot(['user_id', 'answers', 'score', 'results', 'begin_at', 'finish_at', 'correct_at'])->wherePivot('exam_id', $this->id);
    }

    public function paper()
    {
    	return $this->hasOne('App\Paper', 'id', 'paper_id');
    }

}
