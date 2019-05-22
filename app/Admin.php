<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends User
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'admins';
    protected $primaryKey = 'id';

    function college(){
        return $this->belongsTo(College::class,'college_id','id');
    }
    public function classes()
    {
        return $this->belongsTo(Classes::class,'class_id','id');
    }
}
