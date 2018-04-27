<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserExamResource extends Resource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'answers' => $this->pivot->answers,
            'score' => $this->pivot->score,
            'begin_at' => $this->pivot->begin_at,
            'correct_at' => $this->pivot->correct_at,
            'finish_at' => $this->pivot->finish_at
        ];
    }
}
