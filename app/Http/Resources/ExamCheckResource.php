<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ExamCheckResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user_id' => $this->pivot->user_id,
            'exam_id' => $this->pivot->exam_id,
            'begin_at' => $this->pivot->begin_at,
            'finish_at' => $this->pivot->finish_at,
            'correct_at' => $this->pivot->correct_at,
            'paper' => $this->paper,
            'questions' => $this->paper->questions(),
            'score' => $this->pivot->score,
            'results' => json_decode($this->pivot->results)
        ];
    }
}
