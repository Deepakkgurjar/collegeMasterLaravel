<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $table = "subjects";
    //
    protected $dates = ['deleted_at'];

    function Course(){

        return $this->hasMany(Course::class,'subject_id','id');
    }
    function college(){
        return $this->belongsTo(College::class,'college_id','id');
    }
    public function classes()
    {
        return $this->belongsTo(Classes::class,'class_id','id');
    }
}
