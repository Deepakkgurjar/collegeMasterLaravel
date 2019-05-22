<?php

namespace App\Http\Controllers\College;
use App\Admin;
use App\Channel;
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
use App\CollegePost;
use App\PostComment;
use Illuminate\Support\Facades\Validator;
class CollegeController extends Controller
{
                        //--------------------------------------------------------//
                        //--------------------------------------------------------//
                        //                 API'S ROUTES CONTROLLERS
                        //--------------------------------------------------------//
                        //--------------------------------------------------------//

    public function colleges(){

        $user = College::get();
        if (!empty($user)) {
            return response()->json($user, 200);
        } else {
            return response()->json("OOPS! No data found", 400);

        }
    }

    public function collegeclasses(Request $request){
        
        $validationArray = array();
        $validationArray['college_id'] = 'required';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {
            $colleges=College::with('classes')->where('id',$request->college_id)->first();
            if(!empty($colleges)){
                $response['message']="Data Founded";
                $response['classes']=$colleges;
                return response()->json($response, 200);
            }else{
                $response['message']="OOPS! No data found";
                return response()->json($response, 400);
            }
        }
    }

    public function collegepost(Request $request){
        Auth::user();
        $validationArray = array();
        $validationArray['college_id'] = 'required';
        $validator = Validator::make($request->all(),$validationArray);
        if($validator->fails()){
            $response['message']="errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['error_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response,422);
        }else {
           $college_post=CollegePost::where('college_id',Auth::user()->college_id)->get();
            // $college_post =CollegePost::selectRaw('college_post.*,(select count(id) from post_comment where post_id = college_post.id) As total_Comment,
            // coalesce((select (case when user_id = '.Auth::user()->id.' Then "yes" ELSE "no" END) as commentFlag From post_comment WHERE user_id = '.Auth::user()->id.' and post_comment.post_id = college_post.id GROUP by user_id),"n") as commentFlag ')->orderBy('id','desc')
            //     ->with('college_name','class_name','user')->where('college_id',$request->college_id)->get();
dd($college_post);
            if(!empty($college_post)) {
                $response['message'] = "Data Founded";
                $response['College_Post'] = $college_post;
                return response()->json($response, 200);
            }else{
                $response['message'] = 'Oops! No Data Found';
                return response()->json($response,400);
            }
        }
    }

    public function comments(Request $request){
        Auth::user();
        $validationArray = array();
        $validationArray['post_id']='required';
        $validator = Validator::make($request->all(),$validationArray);
        if($validator->fails()){
            $response['message']='errors';
            $response['errors'] = $validator->errors()->toArray();
            $response['error_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        }else{
            $comment_on_post = CollegePost::with('comment_on_post.user.classes','comment_on_post.repliyOnComment.user','user','class_name')->where('id',$request->post_id)->get();
            if(!empty($comment_on_post)){
                $response['message'] = 'Data Founded';
                $response['Comment_on_Post']=$comment_on_post;
                return response()->json($response,200);
            }
        }
    }

    public function studentPost(Request $request){
//        dd(Auth::user());
        $user_detail = Auth::user();
        $validationArray = array();
//        $validationArray['user_id'] = 'required';
//        $validationArray['college_id'] = 'required';
//         $validationArray['class_id'] = 'required';
        $validationArray['post'] = 'required';
        $validationArray['image']='mimes:jpeg,bmp,png';
        $validationArray['video_thumb'] = 'mimes:jpeg,bmp,png';
        $validationArray['video']='mimetypes:video/avi,video/mpeg,video/mp4,video/3gpp,video/quicktime';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = 'errors';
            $response['errors'] = $validator->errors()->toArray();
            $response['error_key'] = $validator->errors()->toArray();
            return response()->json($response, 422);
        } else {
            $student_new_post = new CollegePost;
            $student_new_post->user_id = $user_detail->id;
            $student_new_post->college_id = $user_detail->college_id;
            $student_new_post->class_id = $user_detail->class_id;
            $student_new_post->post = $request->post;
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('storage/image', $filename);
                $pathimg = 'storage/image/' . $filename;
            }
            if ($request->file('video')) {
                $file = $request->file('video');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move("storage/video", $filename);
                $pathvid = 'storage/video/' . $filename;
            }
            if($request->file('video_thumb')){
                $file= $request->file('video_thumb');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('storage/video/thumb', $filename);
                $pathVthumb = 'storage/video/thumb/'.$filename;
            }
            if(!empty($pathimg)){
                $student_new_post->image = $pathimg;
            }

            if(!empty($pathvid)){
                $student_new_post->video = $pathvid;
            }
            if(!empty($pathVthumb)){
                $student_new_post->video_thumb =$pathVthumb;
            }

            $student_new_post->save();
            if (!empty($student_new_post)) {
                $response['message'] = "Data Inserted";
                $response['Your_Post'] = $student_new_post;
                return response()->json($response, 200);
            } else {
                $response['message'] = "OOPS! No data found";
                return response()->json($response, 400);
            }
        }
    }

    public function postComment(Request $request){
        $user_detail = Auth::user();
        $validationArray =array();
        $validationArray['post_id']='required';
        $validationArray['comment']= 'required';
        $validator = Validator::make($request->all(),$validationArray);
        if($validator->fails()){
            $response['message']='errors';
            $response['errors'] = $validator->errors()->toArray();
            $response['error_key']=array_keys($validator->errors()->toArray());
            return response()->json($response,422);
        }else{
            $comment_on_post = new PostComment;
            $comment_on_post->user_id = $user_detail->id;
            $comment_on_post->post_id = $request->post_id;
            $comment_on_post->comment = $request->comment;
            $comment_on_post->save();
            if(!empty($comment_on_post)){
                $response['message'] = "Your Comment";
                $response['Your Comment']=$comment_on_post;
                return response()->json($response,200);
            }
        }

    }

    public function collegeUsers(Request $request){
        Auth::user();
        $validationArray = array();
        $validationArray['college_id'] = 'required';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {

            $collegeuser = User::selectRaw('users.*,(select case when count(id) > 0 Then "y" ELSE "n" End from channel where (from_user_id='.Auth::id().' and to_user_id = users.id  and request="a") OR (to_user_id='.Auth::id().' and from_user_id = users.id and request="a" )) as IsFriend')->where('college_id',$request->college_id)->get();



            if(!empty($collegeuser)){
                $response['message']="Data Founded";
                $response['users']=$collegeuser;

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
    //                                        FOR COLLEGE GROUP
    //-----------------------------------------------------------------------------------------------------------//


    public function collegelist(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $colleges = College::orderBy('id','desc')->get();
        return view('admin.college.list',compact('colleges'));
    }

    public function collegeform(){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        return view('admin.college.form');
    }

    public function registerclg(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[
            'college' => 'required',
        ]);
        $college = new college;
        $college->college = $request->college;
        $college->save();
        return redirect()->back()->with('message','College Added sucessfully');


    }

    public function deleteclg($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        College::where('id',$id)->delete();
        User::where('college_id',$id)->delete();
        Subject::where('college_id',$id)->delete();
        Classes::where('college_id',$id)->delete();
        Course::where('subject_id',$id)->delete();

        VideoDetail::where('course_id',$id)->delete();



//        $del = College::find($id);
//        $del->delete();

        return redirect()->back()->with('message','College Delete sucessfully');

    }

    public function updateclg($id){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $collegeData= College::where('id',$id)->first();
        if(!empty($collegeData)){
            return view('admin.college.edit',compact('collegeData'));
        }else{
            return redirect()->back()->with('error','College not Found');
        }
    }

    public function updatecollegeData(Request $request){
        if(checkSubAdmin()){
            return redirect()->route('home');
        }
        $this->validate($request,[
            'id'=>'required',
            'college' => 'required',
        ]);
        College::where('id',$request->id)->update(array('college'=>$request->college));
        return redirect()->back()->with('message','College Update sucessfully');
    }








}
