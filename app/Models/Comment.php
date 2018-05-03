<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public  $timestamps  = true;
    protected $table = 'comments';
    protected $fillable = [
        'id', 'body', 'discuss_id','user_id','created_at','updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function user()
    {
        return $this->hasMany('App\User', 'id','user_id');
    }
}
