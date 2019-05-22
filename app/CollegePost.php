<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollegePost extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'college_post';

    function college_name(){

        return $this->belongsTo(College::class,'college_id','id');
    }
    function class_name(){
        return $this->belongsTo(Classes::class,'class_id','id');
    }
    function comments(){
        return $this->hasMany(PostComment::class,'post_id','id');
    }

    function comment_on_post(){
        return $this->hasMany(PostComment::class,'post_id','id')->orderBy('id','desc');
    }

    function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }







//    function commentuser(){
//        return $this->belongsTo();
//    }


}
