<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PrivateMessageResource extends Resource
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
            'from' => $this->notifiable_id,
            'to' => $this->data['notifiable_id'],
            'data' => $this->data['data'],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
