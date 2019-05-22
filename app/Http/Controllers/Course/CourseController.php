<?php

namespace App\Http\Controllers\Course;

use App\College;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use App\Classes;
use App\Subject;
use DB;
use App\VideoDetail;
class CourseController extends Controller{

                            //--------------------------------------------------------//
                            //--------------------------------------------------------//
                            //                 API'S ROUTES CONTROLLERS
                            //--------------------------------------------------------//
                            //--------------------------------------------------------//


    public function coursedetail(Request $request){
        Auth::user();
        $validationArray = array();
        $validationArray['course_id'] = 'required';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {
            $videodetails=Course::with('videoDetails')->where('id',$request->course_id)->first();
            if(!empty($videodetails)){
                $response['message']="Data Founded";
                $response['classes']=$videodetails;
                return response()->json($response, 200);
            }else{
                $response['message']="OOPS! No data found";
                return response()->json($response, 400);
            }
        }
    }


                            //--------------------------------------------------------//
                            //--------------------------------------------------------//
                            //                  WEB ROUTES CONTROLLERS
                            //--------------------------------------------------------//
                            //--------------------------------------------------------//

    //-------------------------------------------------------------------------------------------------------------//
    //                                        FOR Course GROUP
    //-----------------------------------------------------------------------------------------------------------//


    public function courselist($subject_id = null){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        if (!empty($subject_id)) {

            $sublist = Course::where('subject_id', $subject_id)->get();

            if (count($sublist) > 0) {

                return view('admin.course.courselist', compact('sublist'));

            } else {

                return redirect()->back()->with('error', 'Sorry! There is no Course');

            }
        } else {
            $sublist = Course::orderBy('id', 'desc')->get();
            return view('admin.course.courselist', compact('sublist'));
        }
    }

    public function registercourse(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[
            'college_id'=>'required',
            'class_id'=>'required',
            'subject_id'=>'required',
            'course'=>'required',
            'course_description'=>'required',
            'taughtby'=>'required',
            'course_duration'=>'required',
            'prerequisites'=>'required',
        ]);
        $course = new Course;
        $course->subject_id = $request->subject_id;
        $course->course = $request->course;
        $course->course_description = $request->course_description;
        $course->taughtby = $request->taughtby;
        $course->course_duration = $request->course_duration;
        $course->prerequisites = $request->prerequisites;
        $course->save();
        return redirect()->back()->with('message','Course Added Sucessfully');

    }

    public function deletecourse($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        Course::where('id',$id)->delete();
        Subject::where('id',$id)->delete();
        VideoDetail::where('course_id',$id)->delete();

        return redirect()->back()->with('message','Course Delete sucessfully');


    }

    public function updatecourse($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $courseupdate=Course::where('id',$id)->first();
        if(!empty($courseupdate)){
            return view('admin.course.courseupdate',compact('courseupdate'));
        }else{
            return redirect()->back()->with('error','Course not Found');
        }

    }

    public function updatecourseData(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[
            'id'=>'required',
            'course' => 'required',
            'course_description' =>'required',
            'taughtby'=>'required',
            'course_duration'=>'required',
            'prerequisites'=>'required',
        ]);


        Course::where('id',$request->id)->update(array('course'=>$request->course));
        Course::where('id',$request->id)->update(array('course_description' => $request->course_description));
        Course::where('id',$request->id)->update(array('taughtby'=>$request->taughtby));
        Course::where('id',$request->id)->update(array('course_duration'=>$request->course_duration));
        Course::where('id',$request->id)->update(array('prerequisites'=>$request->prerequisites));


        return redirect()->back()->with('message','Course Update sucessfully');


    }

    public function addcourse(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $colleges = College::orderBy('id','desc')->get();

        return view('admin.course.addcourse',compact('colleges'));
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

    public function subjectfetch($id){

        $subject = Subject::where('class_id',$id)->get();
        if(count($subject)>0){
            $html = "<option value=''>Select Subject</option>";
            foreach ($subject as $key => $value){
                $html.="<option value = ".$value->id.">".$value->subject."</option>";
            }
            echo $html;
        }else{
            $response ['message']="Sorry! There is no Subject";
            return response()->json($response,400);
        }
    }



}
