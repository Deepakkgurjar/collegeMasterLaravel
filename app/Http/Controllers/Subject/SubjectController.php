<?php

namespace App\Http\Controllers\Subject;

use App\Admin;
use App\Classes;
use App\College;
use App\Course;
use App\Subject;
use DB;
use App\User;
use App\VideoDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
class SubjectController extends Controller{

                                    //--------------------------------------------------------//
                                    //--------------------------------------------------------//
                                    //                 API'S ROUTES CONTROLLERS
                                    //--------------------------------------------------------//
                                    //--------------------------------------------------------//


    public function course(Request $request){
        Auth::user();
        $validationArray = array();
        $validationArray['subject_id'] = 'required';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {
            $course=Subject::with('course')->where('id',$request->subject_id)->first();
            if(!empty($course)){
                $response['message']="Data Founded";
                $response['classes']=$course;
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
    //
    //                                        FOR SUBJECT GROUP
    //-----------------------------------------------------------------------------------------------------------//


    public function subjectlist($class_id=null){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        if(!empty($class_id)){
            $sublist = Subject::where('class_id',$class_id)->get();
            if(count($sublist)>0){
                return view('admin.subject.subjectlist',compact('sublist'));
            }else{
                return redirect()->back()->with('error','Sorry! There is no Subjects');
            }
        }else{
            $sublist = Subject::orderBy('id','desc')->get();
            return view('admin.subject.subjectlist',compact('sublist'));
        }
    }

    public function deletesubject($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        Subject::where('id',$id)->delete();
        Course::where('subject_id',$id)->delete();
        VideoDetail::where('course_id',$id)->delete();
        return redirect()->back()->with('message','Subject Delete Sucessfully');
    }

    public function updatesubject($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $subjectupdate = Subject::where('id',$id)->first();
        if(!empty($subjectupdate)){
            return view('admin.subject.subjectupdate',compact('subjectupdate'));
        }else{
            return redirect()->back()->with('message','Subject Not Found');
        }

    }

    public function addsubject(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $colleges = College::orderBy('id','desc')->get();

        return view('admin.subject.addsubject',compact('colleges'));

    }

    public function updatesubjectData(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request, [
            'id' => 'required',

            'subject' => 'required',

        ]);


        Subject::where('id',$request->id)->update(array('subject'=>$request->subject));
        return redirect()->back()->with('message','Course Update sucessfully');
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

    public function registersubject(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[
            'college_id'=>'required',
            'class_id'=>'required',
            'subject'=>'required',

        ]);
        $subject= new Subject;
        $subject->college_id =$request->college_id;
        $subject->class_id=$request->class_id;
        $subject->subject=$request->subject;
        $subject->save();
        return redirect()->back()->with('message','Subject Added Sucessfully');
    }

}
