<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\QuestionType;


class QuestionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $type = $this->Type;
        return  [
            'id' => $this->id,
            'type_id' => $this->type_id,
            'type' => $request->get('includeType') == 'yes' ? $type : null,
            'level_type' => $this->level_type,
            'title' => $this->title,
            'body' => explode($type->delimiter, $this->body),
            'answer' => explode($type->delimiter, $this->answer),
            'answer_comment' => $this->answer_comment,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
