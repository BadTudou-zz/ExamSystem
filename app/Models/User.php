<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function organizations()
    {
        return $this->belongsToMany('App\Organization','organization_user', 'user_id', 'organization_id');
    }

    public function lectures()
    {
        return $this->belongsToMany('App\Lecture', 'lecture_user', 'user_id', 'lecture_id');
    }

    public function exams()
    {
        return $this->belongsToMany('App\Exam','exam_user', 'user_id', 'exam_id')->withTimestamps()->withPivot(['answers', 'begin_at', 'finish_at'])->wherePivot('user_id', $this->id);
    }

}
