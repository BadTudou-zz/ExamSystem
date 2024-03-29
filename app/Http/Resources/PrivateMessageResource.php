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
            'to' => json_decode($this->data)->notifiable_id,
            'from_name' => json_decode($this->data)->from_name,
            'to_name' => json_decode($this->data)->to_name,
            'data' => json_decode($this->data)->data,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
