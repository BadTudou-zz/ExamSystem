<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public  $timestamps  = false;
    protected $table = 'document';
    protected $fillable = [
        'id', 'cid', 'userid','url','doc_name','kp'
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
        return $this->hasMany('App\User', 'id','userid');
    }


}
