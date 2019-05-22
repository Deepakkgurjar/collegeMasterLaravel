<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Chat extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'chat';

    function getsenderId(){
        return $this->belongsTo(Channel::class,'channel_id','id');
    }

    public function getuser(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function getFromUser(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function lastchat(){
        return $this->belongsTo(User::class,'message','id');
    }


    public function getToUser(){
        return $this->belongsTo(User::class,'to_user_id','id');
    }
}
