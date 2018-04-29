<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaperSection extends Model
{
    protected $fillable = ['name', 'describe', 'question_type', 'score', 'number', 'questions', 'scores'];

    public function Type()
    {
        return $this->belongsTo('App\QuestionType', 'question_type');
    }
}
