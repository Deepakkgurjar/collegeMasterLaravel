<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Course extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'courses';

    function subject(){

        return $this->belongsTo(Subject::class,'subject_id','id');
    }
    function videoDetails(){
        return $this->hasMany(VideoDetail::class,'course_id','id');
    }

    //


}
