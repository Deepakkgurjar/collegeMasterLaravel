<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class VideoDetail extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'video_details';

    function course(){

        return $this->belongsTo(Course::class,'course_id','id');
    }
}
