<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RepliedComment extends Model
{
    //
use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'reply_comment';


    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
