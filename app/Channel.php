<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Channel extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'channel';

    public function getToUser(){
        return $this->belongsTo(User::class,'to','id');
    }
}
