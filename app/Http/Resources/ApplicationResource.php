<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ApplicationResource extends Resource
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
            'from_name' => $this->data['from_name'],
            'to_name' => $this->data['to_name'],
            'action' => $this->data['action'],
            'resource_id' => $this->data['resource_id'],
            'resource_type' => $this->data['resource_type'],
            'data' => $this->data['data'],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
