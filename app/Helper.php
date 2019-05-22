<?php
use App\ForgotPassword;
function checkSubAdmin(){

//    dd(Auth::guard('admin')->user());
    if(Auth::guard('admin')->user()->sub_admin_flag == "subadmin"){
        return true;
    }else{
        return false;
    }

}




?>