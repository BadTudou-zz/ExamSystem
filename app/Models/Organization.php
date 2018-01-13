<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name', 'creator_id', 'describe', 'max', 'current'
    ];

    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'organization_user', 'user_id', 'organization_id');
    }
}
