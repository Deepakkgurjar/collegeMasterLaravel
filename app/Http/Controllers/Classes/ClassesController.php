<?php

namespace App\Http\Controllers\Classes;
use App\Admin;
use App\Classes;
use App\College;
use App\Course;
use App\Subject;
use DB;
use App\VideoDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{

                            //--------------------------------------------------------//
                            //--------------------------------------------------------//
                            //                 API'S ROUTES CONTROLLERS
                            //--------------------------------------------------------//
                            //--------------------------------------------------------//

    public function subject(Request $request){
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
            $subject=Classes::with('subject')->where('id',$request->class_id)->first();
            if(!empty($subject)){
                $response['message']="Data Founded";
                $response['classes']=$subject;
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
    //                                        FOR CLASS GROUP
    //-----------------------------------------------------------------------------------------------------------//


    public function classlist(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        return view('admin.class.classlist', [
            'colleges' => College::all(),

        ]);

    }

    public function classeslist($college_id=null){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        if(!empty($college_id)){
            $clslist = Classes::where('college_id',$college_id)->get();
            if(count($clslist)>0) {
                return view('admin.class.classeslist',compact('clslist'));
            }else{
                return redirect()->back()->with('error','Sorry! There is no classes');
            }
        }else{
            $clslist = Classes::orderBy('id','desc')->get();
            return view('admin.class.classeslist',compact('clslist'));
        }
    }

    public function deletecls($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        Classes::where('id',$id)->delete();
        Subject::where('class_id',$id)->delete();
        Course::where('subject_id',$id)->delete();
        VideoDetail::where('course_id',$id)->delete();


        return redirect()->back()->with('message','Class Delete sucessfully');

    }

    public function updatecls($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $classData = Classes::where('id',$id)->first();
        if(!empty($classData)){

            return view('admin.class.edit',compact('classData'));
        }else{
            return redirect()->back()->with('error','Class not Found');
        }


    }

    public function updateclassData(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[
            'id'=>'required',
            'class' => 'required',
        ]);

        Classes::where('id',$request->id)->update(array('class'=>$request->class));

        return redirect()->back()->with('message','class Update sucessfully');


    }

    public function addclass(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $colleges = College::orderBy('id','desc')->get();
        return view('admin.class.classlist',compact('colleges'));
    }

    public function registercls(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }

        $this->validate($request,[
            'college_id'=>'required',
            'class' => 'required',
        ]);

        $class = new Classes;
        $class->college_id = $request->college_id;
        $class->class = $request->class;
        $class->save();
        return redirect()->back()->with('message','Class Added sucessfully');

    }

}
