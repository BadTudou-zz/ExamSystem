<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'type_id', 'level_type', 'tags', 'title', 'body', 'answer', 'answer_comment'
    ];

    public function Type()
    {
        return $this->belongsTo('App\QuestionType', 'type_id');
    }
}
