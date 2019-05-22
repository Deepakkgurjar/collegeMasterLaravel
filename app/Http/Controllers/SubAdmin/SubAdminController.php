<?php

namespace App\Http\Controllers\SubAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\College;
use App\Admin;
use App\Classes;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;

class SubAdminController extends Controller{

                                    //--------------------------------------------------------//
                                    //--------------------------------------------------------//
                                    //                 API'S ROUTES CONTROLLERS
                                    //--------------------------------------------------------//
                                    //--------------------------------------------------------//

    //-------------------------------------------------------------------------------------------------------------//
    //                                        There is no API's
    //-------------------------------------------------------------------------------------------------------------//




                                    //--------------------------------------------------------//
                                    //--------------------------------------------------------//
                                    //                  WEB ROUTES CONTROLLERS
                                    //--------------------------------------------------------//
                                    //--------------------------------------------------------//



    //-------------------------------------------------------------------------------------------------------------//
    //                                        FOR STUDENT GROUP
    //-----------------------------------------------------------------------------------------------------------//



    public function subAdminList(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $subAdminList = Admin::orderBy('id','desc')->where('sub_admin_flag','subadmin')->get();
        return view('admin.classrepresentative.viewcr',compact('subAdminList'));
    }

    public function addSubAdmin(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $colleges = College::orderBy('id','desc')->get();

        return view('admin.classrepresentative.addcr',compact('colleges'));

    }

    public function deleteSubAdmin($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        Admin::where('id',$id)->delete();
        return redirect()->back()->with('message','Sub Admin Delete Sucessfully');
    }

    public function updateSubAdmin($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $updateSubAdmin = Admin::where('id',$id)->first();
        if(!empty($updateSubAdmin)){
            return view('admin.classrepresentative.updateSubadmin',compact('updateSubAdmin'));

        }else{
            return redirect()->back()->with('error','Sorry! Data Not Found');
        }


    }

    public function updatesubadminData(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[
            'email'=>'required',
            'password'=>'required',
        ]);

       /* Admin::where('id',$request->id)->update(array('email'=>$request->email));
        Admin::where('id',$request->id)->update(array(Hash::make($request->password)'password' => $request->password));*/
       $data =  array(
           "email" => $request-> email,
           "password" => Hash::make($request->password),
       );
        Admin::where('id',$request->id)->update($data);

        return redirect()->back()->with('message','Sub Admin Details Update sucessfully');



    }

    public function makeSubAdmin(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }


        $this->validate($request, [
            'college_id'=>'required',
            'class_id'=>'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $subAdmin = new Admin;
        $subAdmin->college_id= $request->college_id;
        $subAdmin->class_id= $request->class_id;
        $subAdmin -> email = $request->email;
        $subAdmin ->password = Hash::make($request->password);
        $subAdmin -> save();
        Admin::where('email',$request->email)->update(array('sub_admin_flag'=>'subadmin'));
        Mail::to($request->email)->send(new UserMail($request->email,$request->password));
        return redirect()->back()->with('message','Sub Admin Created Sucessfully');



    }

    public function classfetch($id){

        $class = Classes::where('college_id', $id)->get();
        if(count($class)>0){
            $html= "<option value=''>Select Class</option>";

            foreach ($class as $key => $value ){

                $html.="<option value=".$value->id.">".$value->class."</option>";

            }
            echo $html;
        }else{
            $respnose['message'] = "Sorry! There is no Classes.";
            return response()->json($respnose,400);

        }


    }

}
