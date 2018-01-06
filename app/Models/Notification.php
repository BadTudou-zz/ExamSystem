<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    public function getIdAttribute($value)
    {
        return $this->attributes['id'];
    }
}
