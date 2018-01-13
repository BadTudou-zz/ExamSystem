<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OrganizationResource extends Resource
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
            'creator_id' => $this->creator_id,
            'describe' => $this->describe,
            'max' => $this->max,
            'current' => $this->current,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
