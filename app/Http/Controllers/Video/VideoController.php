<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\College;
use App\Course;
use App\Classes;
use App\Subject;
use DB;
use App\VideoDetail;
class VideoController extends Controller{


                            //--------------------------------------------------------//
                            //--------------------------------------------------------//
                            //                 API'S ROUTES CONTROLLERS
                            //--------------------------------------------------------//
                            //--------------------------------------------------------//


                                    //THERE IS NO  API'S



                            //--------------------------------------------------------//
                            //--------------------------------------------------------//
                            //                  WEB ROUTES CONTROLLERS
                            //--------------------------------------------------------//
                            //--------------------------------------------------------//

    //-------------------------------------------------------------------------------------------------------------//
    //                                        FOR VIDEO GROUP
    //-----------------------------------------------------------------------------------------------------------//


    public function videolist($course_id =null){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        if(!empty($course_id)){
            $videolist = VideoDetail::where('course_id',$course_id)->get();
            if(count($videolist)>0){
                return view('admin.video.videolist',compact('videolist'));
            }else{
                return redirect()->back()->with('error','Sorry! There is no Videos');
            }
        }else{
            $videolist= VideoDetail::orderBy('id','desc')->get();
            return view('admin.video.videolist',compact('videolist'));
        }

    }

    public function addvideo(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $colleges = College::orderBy('id','desc')->get();

        return view('admin.video.addvideo',compact('colleges'));

    }

    public function uploadvideo(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[

            'college_id'=>'required',
            'class_id'=>'required',
            'subject_id'=>'required',
            'course_id'=>'required',
            'title'=>'required',
            'video_description'=>'required',
            'video_thumb'=>'required | mimes:jpeg,bmp,png',
            'video'=>'required | mimetypes:video/avi,video/mpeg,video/mp4,video/3gpp,video/quicktime',
        ]);
        if($request->file('video_thumb')){
            $file = $request->file('video_thumb');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move("storage/video/videoThumb/",$filename);
            $path_thumb = 'storage/video/videoThumb/'.$filename;
//            $file>storeAs("storage/",$file->getClientOriginalName());
        }
        if($request->file('video')){
            $file = $request->file('video');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move("storage/video/",$filename);
            $path = 'storage/video/'.$filename;
//            $file>storeAs("storage/",$file->getClientOriginalName());
        }

        $video = new VideoDetail;
        $video->course_id = $request->course_id;
        $video->title = $request->title;
        $video->video_description = $request->video_description;
        $video->video_thumb = $path_thumb;
        $video->video = $path;
        $video->save();
        return redirect()->back()->with('message','Video Added Sucessfully');


    }

    public function deletevideo($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        VideoDetail::where('id',$id)->delete();
        return redirect()->back()->with('message','Video Delete Sucessfully');
    }

    public function updatevideo($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $videoupdate = VideoDetail::where('id',$id)->first();
        if(!empty($videoupdate)){
            return view('admin.video.videoupdate',compact('videoupdate'));
        }else{
            return redirect()->back()->with('error','Video Not Found.');
        }
    }

    public function updatevideoData(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[
            'id'=>'required',
            'title'=>'required',
            'video_description'=>'required',
            'video_thumb'=>'mimes:jpeg,bmp,jpg,png',
            'video'=>'mimetypes:video/avi,video/mpeg,video/mp4,video/3gpp,video/quicktime',
        ]);

        if($request->file('video_thumb')){
            $file = $request->file('video_thumb');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move("storage/video/videoThumb/",$filename);
            $path_thumb = 'storage/video/videoThumb/'.$filename;
//            $file>storeAs("storage/",$file->getClientOriginalName());
        }

        if($request->file('video')){
            $file = $request->file('video');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move("storage/video",$filename);
            $path = 'storage/video/'.$filename;
//            $file>storeAs("storage/",$file->getClientOriginalName());
        }



        if(empty($request->video_thumb) && empty($request->video)){
            $data  = array(
                "title" => $request->title,
                'video_description'=>$request->video_description,


            );

            VideoDetail::where('id',$request->id)->update($data);
            return redirect()->back()->with('message','Video Update sucessfully');
        }

        if(!empty($request->video_thumb) && !empty($request->video)){
            $data  = array(
                "title" => $request->title,
                'video_description'=>$request->video_description,
                'video'=>$path,
                'video_thumb'=>$path_thumb,
            );

            VideoDetail::where('id',$request->id)->update($data);
            return redirect()->back()->with('message','Video Update sucessfully');
        }

        if(!empty($request->video_thumb)){
            $data  = array(
                "title" => $request->title,
                'video_description'=>$request->video_description,
                'video_thumb'=>$path_thumb,
            );

            VideoDetail::where('id',$request->id)->update($data);
            return redirect()->back()->with('message','Video Update sucessfully');
        }

        if(!empty($request->video)){
            $data  = array(
                "title" => $request->title,
                'video_description'=>$request->video_description,
                'video'=>$path,
            );

            VideoDetail::where('id',$request->id)->update($data);
            return redirect()->back()->with('message','Video Update sucessfully');
        }

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

    public function coursefetch($id){
        $course = Course::where('subject_id',$id)->get();
        if(count($course)>0){
            $html = "<option value=''>Select Course</option>";
            foreach ($course as $key=>$value){
                $html.="<option value = ".$value->id.">".$value->course."</option>";
            }
            echo $html;
        }else{
            $response ['message']="Sorry! Ther is no Course";
            return response()->json($response,400);
        }
    }

    public function viewvideo($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $video =  VideoDetail::where('id',$id)->first();
        return view('admin.video.viewvideo',compact('video'));
    }

}
