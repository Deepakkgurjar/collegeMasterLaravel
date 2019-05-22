<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class College extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $table = "college";

    function classes(){

        return $this->hasMany(Classes::class,'college_id','id');
    }
    function subject(){

        return $this->hasMany(Subject::class,'class_id','id');

    }






}
