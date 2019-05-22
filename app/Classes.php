<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "class";


    public function college()
    {
        return $this->belongsTo(College::class,'college_id','id');
    }
    function Subject(){

        return $this->hasMany(Subject::class,'class_id','id');
    }



}
