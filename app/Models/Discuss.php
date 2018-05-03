<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discuss extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public  $timestamps  = true;
    protected $table = 'discuss';
    protected $fillable = [
        'id', 'l_id', 'title','content','userid','updated_at','created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function replys()
    {
        return $this->hasMany('App\Models\Comment', 'discuss_id');
    }

    public function user()
    {
        return $this->hasMany('App\User', 'id','userid');
    }

}
