<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionType extends Model
{
    protected $fillable = [
        'name', 'title', 'delimiter'
    ];

    public function Questions()
    {
        return $this->hasMany('App\Question', 'type_id');
    }
}
