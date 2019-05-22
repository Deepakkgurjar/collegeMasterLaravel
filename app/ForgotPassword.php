<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForgotPassword extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'forgot_password';

}
