<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\PaperSection;
use App\Question;

class Paper extends Model
{
    protected $fillable = [
        'creator_id', 'title', 'score', 'min', 'describe', 'sections', 'tags'
    ];

    public function sections()
    {
    	$sectionIds = explode(",", $this->sections);
    	return PaperSection::whereIn('id', $sectionIds)->get();
    }

    public function questions()
    {
    	$questions = implode(',', array_column($this->sections()->all(), 'questions'));
        $questionIds=  explode(",", $questions);
    	return Question::whereIn('id', $questionIds)->get();
    }

    public function scores()
    {
        return array_column($this->sections()->all(), 'scores');
    }
}