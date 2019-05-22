<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    //
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'post_comment';

public function user(){
return $this->belongsTo(User::class,'user_id','id');
}

    function repliyOnComment(){
        return $this->hasMany(RepliedComment::class,'comment_id','id');
    }



}
