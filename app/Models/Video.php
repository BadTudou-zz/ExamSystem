<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Video extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public  $timestamps  = false;
    protected $table = 'video';
    protected $fillable = [
        'id', 'cid', 'userid','url','video_name','kp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];


}
