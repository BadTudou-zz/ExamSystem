<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PaperSectionResource extends Resource
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
            'describe' =>  $this->describe,
            'question_type' => $this->question_type,
            'type' => $this->Type,
            'score' => $this->score,
            'number' => $this->number,
            'questions' => $this->questions,
            'scores' => json_decode($this->scores),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
