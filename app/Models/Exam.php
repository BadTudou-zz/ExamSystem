<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['creator_id', 'paper_id', 'title', 'exam_type', 'score', 'min', 'describe', 'allowable_lecture_ids', 'allowable_orgaization_ids', 'allowable_user_ids', 'begin_at', 'start_at', 'finish_at'];

}
