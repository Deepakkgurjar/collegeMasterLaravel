<?php

namespace App\Http\Controllers\User;
use App\Course;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\PostComment;
use App\RepliedComment;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller{


                                    //--------------------------------------------------------//
                                    //--------------------------------------------------------//
                                    //                 API'S ROUTES CONTROLLERS
                                    //--------------------------------------------------------//
                                    //--------------------------------------------------------//



    public function read(){
        Auth::user();
//        $user = User::get();
//        return response()->json($user, 200);
        $user = User::with("getcollege","getclass","getsubject","getcourse")->first();
        if (!empty($user)) {
            return response()->json($user, 200);
        } else {
            $respond['message']="OOPS! Check your Token ";
            return response()->json($respond, 400);
        }
    }

    public function classUsers(Request $request){
        Auth::user();
        $validationArray = array();
        $validationArray['class_id'] = 'required';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {
            $classuser = User::where('class_id',$request->class_id)->get();
            //dd($classuser);
            if(!empty($classuser)){
                $response['message']="Data Founded";
                $response['classes']=$classuser;
                return response()->json($response, 200);
            }else{
                $response['message']="OOPS! No data found";
                return response()->json($response, 400);
            }
        }

    }



    public function getProfile(Request $request){
        Auth::user();
        $user = User::where('api_token',$request->api_token)->get();

        if (!empty($user)) {
            return response()->json($user, 200);
        } else {
            return response()->json("OOPS! No data found", 400);

        }

    }

    public function updateProfile(Request $request){

        Auth::user();
        $validationArray = array();
//        $validationArray['api_token'] = 'required';
        $validationArray['username'] = 'required';

        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {

            $userData = User::where('api_token', $request->api_token)->first();
            if (empty($userData)) {
                $respond['message'] = "api_token not exist or invalid";
                return response()->json($respond, 400);
            }else{

                $already = User::where('virtual_name',$request->username)->first();
                if(empty($already)){
                    $update =  array(
                        "virtual_name" => $request->username,

                    );
                    User::where('api_token',$request->api_token)->update($update);
                    $respond['message'] = "Update sucessfully.";
                    return response()->json($respond, 200);

                }else{
                    $respond['error'] = "message','Username Already Taken.";
                    $respond['error_key'] = "error ','Username ";
                    return response()->json($respond, 400);

                }

            }
        }
    }

    public function viewStudentProfile(Request $request){
        Auth::user();
        $validationArray = array();
        $validationArray['id']='required';
        $validator= Validator::make($request->all(),$validationArray);
        if($validator->fails()){
            $response['message']='errors';
            $response['errors']=$validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        }else{

            $subjesc = Subject::where('college_id',Auth::user()->college_id)->where('class_id',Auth::user()->class_id)->with('Course')->get();



            $studentProfile = User::where('id',$request->id)->with('college','classes')->first();

            if(empty($studentProfile)){
                $response['message']='This User id is not exist or invalid ';
                return response()->json($response, 400);
            }

            $response['message']= 'result';

            $response['user']= $studentProfile;
            $response['Subject']= $subjesc;
            return response()->json($response, 200);


        }
    }

    public function replyOnComment(Request $request){
        Auth::user();
        $validatonArray = array();
        $validatonArray['comment_id']='required';
        $validatonArray['comment']='required';
        $validator=Validator::make($request->all(),$validatonArray);
        if($validator->fails()){
            $response['message']='errors';
            $response['errors']=$validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        }else{
            $commentData= PostComment::where('id',$request->comment_id)->first();
            if(empty($commentData)){
                $response['message']='This comment id is not exist or invalid ';
                return response()->json($response, 400);
            }

            $repliedComment = new RepliedComment();

            $repliedComment->user_id = Auth::user()->id;
            $repliedComment->comment_id = $request->comment_id;
            $repliedComment->post_id = $commentData->post_id;
            $repliedComment->comment = $request->comment;
            $repliedComment->time = time();

            $repliedComment->save();
            $response['message']= 'message send';
            $response['Your_Message'] = $repliedComment;
            $response['User']= Auth::user();

            return response()->json($response, 200);
        }
    }


                                //--------------------------------------------------------//
                                //--------------------------------------------------------//
                                //                  WEB ROUTES CONTROLLERS
                                //--------------------------------------------------------//
                                //--------------------------------------------------------//



    //-------------------------------------------------------------------------------------------------------------//
    //                                        FOR STUDENT GROUP
    //-----------------------------------------------------------------------------------------------------------//


    public function approvedstudentlist(){
        $approvedstudent = User::orderBy('id','desc')->where('verify','y')->with('college','classes');
        if(Auth::guard('admin')->user()->sub_admin_flag == "subadmin"){

            if(!empty($approvedstudent)){
                $approvedstudent  = $approvedstudent->where('college_id',Auth::guard('admin')->user()->college_id)
                    ->where('class_id',Auth::guard('admin')->user()->class_id)->get();
                return view('admin.student.approved',compact('approvedstudent'));
            }

        }else{
            $approvedstudent = User::orderBy('id','desc')->where('verify','y')->with('college','classes')->get();
            return view('admin.student.approved',compact('approvedstudent'));
        }

    }

    public function studentdetails($id){
        $personaldetail = User::where('id',$id)->with('college','classes')->first();

        return view('admin.student.studentdetail',compact('personaldetail'));
    }

    public function notapprovestudentlist(){
        $notapprovestudentlist = User::orderBy('id','desc')->where('verify','n')->with('college','classes');
        if(Auth::guard('admin')->user()->sub_admin_flag == "subadmin") {
            if (!empty($notapprovestudentlist)) {
                $notapprovestudentlist = $notapprovestudentlist->where('college_id', Auth::guard('admin')->user()->college_id)
                    ->where('class_id', Auth::guard('admin')->user()->class_id)->get();
                return view('admin.student.notapprove', compact('notapprovestudentlist'));
            }
        }else{
            $notapprovestudentlist = User::orderBy('id','desc')->where('verify','n')->with('college','classes')->get();
            return view('admin.student.notapprove',compact('notapprovestudentlist'));
        }
    }

    public function approvel($id){
        if(Auth::guard('admin')->user()->sub_admin_flag == "subadmin"){
            $check = User::where('id',$id)->first();
            if(!empty($check)){
                if($check->verify=='n'){
                    User::where('id',$id)->update(array('verify'=>'y'));
                    User::where('id',$id)->update(array('approved_by'=>'subadmin'));
                    return redirect()->back()->with('message','Approval Accept.');
                }else{
                    User::where('id',$id)->update(array('verify'=>'n'));
                    return redirect()->back()->with('message','Approval  Disapproved.');
                }
            }else{
                return redirect()->back()->with('error','Student not exist');
            }

        }else{
            $check = User::where('id',$id)->first();
            if(!empty($check)){
                if($check->verify=='n'){
                    User::where('id',$id)->update(array('verify'=>'y'));
                    User::where('id',$id)->update(array('approved_by'=>'admin'));
                    return redirect()->back()->with('message','Approval Accept.');
                }else{
                    User::where('id',$id)->update(array('verify'=>'n'));
                    return redirect()->back()->with('message','Approval  Disapproved.');
                }
            }else{
                return redirect()->back()->with('error','Student not exist');
            }

        }

    }

}
