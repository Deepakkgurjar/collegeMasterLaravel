<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Builder\Class_;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','college_id','class_id','year', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',


    ];

    public function getcollege(){

        return $this->belongsTo(College::class,"college_id","id");

    }
    public function getclass(){
        return $this->belongsTo(Classes::class,"class_id","id");
    }

    public function getsubject(){
        return $this->belongsTo(Subject::class,"id","id");
    }




    public function getcourse(){
        return $this->belongsTo(Course::class,"id","id");
    }



    public function college(){
        return $this->belongsTo(College::class,"college_id","id");
    }

    public function classes(){
        return $this->belongsTo(Classes::class,'class_id','id');
    }

    public function friendrequest(){
        return $this->belongsTo(Channel::class,'id','to_user_id');
    }





}

