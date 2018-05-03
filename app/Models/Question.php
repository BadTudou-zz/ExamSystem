<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;

class Question extends Model
{
    protected $fillable = [
        'type_id', 'level_type', 'tags', 'title', 'body', 'answer', 'answer_comment'
    ];

    public function Type()
    {
        return $this->belongsTo('App\QuestionType', 'type_id');
    }

    public function Tags()
    {
        return Tag::whereIn('id', explode(",", $this->tags))->get();
    }

    public function scopeTags($query, $tag)
    {
        return $tag ? $query->where('tags', $tag) : $query;
    }
}
