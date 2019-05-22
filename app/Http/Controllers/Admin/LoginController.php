<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LoginController extends Controller
{
    //
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/home';
    public function __construct()
    {

        $this->middleware('guest:admin')->except('logout');
    }
    

    public function showLoginForm()
    {

        return view('adminlte::login');
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }


    public function redirectTo(){

        return 'admin/home';

    }

    public function passwordreset(){

        return view('adminlte::passwords.email');

    }



}
