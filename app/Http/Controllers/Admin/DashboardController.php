<?php

namespace App\Http\Controllers\Admin;
use App\Admin;
use App\Classes;
use App\College;
use App\Course;
use App\Subject;
use DB;
use App\User;
use App\VideoDetail;
use App\Http\Controllers\Controller;
class DashboardController extends Controller
{
    //
    public function __construct()
    {

    }

    public function index(){

//        /dd(Auth::guard('admin')->user());
        $total_college = College::count();
        $total_class = Classes::count();
        $total_course = Course::count();
        $total_subject = Subject::count();
        $total_video = VideoDetail::count();
        $total_users = User::where('verify','y')->count();
        $dis_user = User::where('verify','n')->count();

        $total_subadmins = Admin::where('sub_admin_flag','subadmin')->count();

        return view('adminlte::dashboard',compact('total_subadmins','total_users','total_video','total_subject','total_course',
            'total_class','total_college','dis_user'));

    }

}
