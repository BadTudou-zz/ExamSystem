<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Preview extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public  $timestamps  = false;
    protected $table = 'preview';
    protected $fillable = [
        'id', 'cid', 'userid','desc','end_time','is_publish','preview_name','content',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];


}
