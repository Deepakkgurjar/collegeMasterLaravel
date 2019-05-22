<?php

namespace App\Http\Controllers\Chats;

use App\Channel;
use App\Chat;
use App\CollegePost;
use App\Notification;
use App\PostComment;
use App\RepliedComment;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        $validationArray = array();
        $validationArray['message'] = 'nullable';
        $validationArray['image']='mimes:jpeg,bmp,jpg,png';
        $validationArray['to'] = 'required|exists:users,id';
        $validator = Validator::make($request->all(), $validationArray);
        $toData = User::where('id', $request->to)->first();
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);

        } else {

            if ($user->id == $request->to) {
                $sameUser['to'] = array();
                array_push($sameUser['to'], "Sorry Please Check Receiver's Number");
                $response['message'] = "errors";
                $response['errors'] = $sameUser;
                $response['errors_key'] = array_keys($sameUser);
                return response()->json($response, 422);
            }

            $channel = Channel::where(function ($q) use ($request, $user) {
                $q->where(function ($query) use ($request, $user) {
                    $query->where('to_user_id', $request->to)
                        ->where('from_user_id', $user->id);
                })->orWhere(function ($query) use ($request, $user) {
                    $query->where('to_user_id', $user->id)
                        ->where('from_user_id', $request->to);
                });
            })->first();

            if($channel != null){
                if($channel->request =='a'){
                    $chat = new  Chat();
                    $chat->channel_id = $channel->id;
                    $chat->user_id = $user->id;
                    $chat->to_user_id= $request->to;
                    $chat->message = $request->message;
                    if($request->file('image')){
                        $file = $request->file('image');
                        $filename=time().'.'.$file->getClientOriginalExtension();
                        $file->move("storage/image/messageImages/",$filename);
                        $path_img = 'storage/image/messageImages/'.$filename;
                    }
                    if(!empty($path_img)){
                        $chat->image = $path_img;
                    }
                    $chat->time = time();
                    $chat->save();
                    $toData = User::where('id',$request->to)->first();
                    if (!empty($chat)) {

                        $response['message'] = "Message Send Sucessfully";
                        $response['Your_Message'] = $chat;
                        $response['user']=$toData;
                        return response()->json($response, 200);
                    } else {
                        $response['message'] = "Something Went Wrong";
                        return response()->json($response, 400);
                    }
                    }else{
                    $requestAcc['Request'] = array();
                    array_push($requestAcc['Request'], " Request has been not Accepted yet.");
                    $response['message'] = "errors";
                    $response['errors'] = $requestAcc;
                    $response['errors_key'] = array_keys($requestAcc);
                    return response()->json($response, 422);
                }

                }

            if ($user->college_id != $toData->college_id || $user->class_id != $toData->class_id) {
                $invalidCollege['user'] = array();
                array_push($invalidCollege['user'], "Sorry This Student is not in your Class or College. If you Want to Chat with him. please send Request.");
                $response['message'] = "errors";
                $response['errors'] = $invalidCollege;
                $response['errors_key'] = array_keys($invalidCollege);
                return response()->json($response, 422);
            }

                $channel_ins = new Channel();
                $channel_ins->to_user_id = $request->to;
                $channel_ins->from_user_id = $user->id;
                $channel_ins->request = 'a';
                $channel_ins->time = time();
                $channel_ins->save();
                $channel_id = $channel_ins->id;

                $chat = new  Chat();
                $chat->channel_id = $channel_id;
                $chat->user_id = $user->id;
                $chat->to_user_id= $request->to;
                $chat->message = $request->message;
            if($request->file('image')){
                $file = $request->file('image');
                $filename=time().'.'.$file->getClientOriginalExtension();
                $file->move("storage/image/messageImages/",$filename);
                $path_img = 'storage/image/messageImages/'.$filename;
            }
            if(!empty($path_img)){
                $chat->image = $path_img;
            }
                $chat->time = time();
                $chat->save();

            if (!empty($chat)) {
                $response['message'] = "Message Send Sucessfully";
                $response['Your_Message'] = $chat;
                $response['user']=$toData;
                return response()->json($response, 200);
            } else {
                $response['message'] = "Something Went Wrong";
                return response()->json($response, 400);
            }

        }

    }

    public function sendRequest(Request $request){

        $validationArray = array();
        $validationArray['to'] = 'required|exists:users,id';
        $validator = Validator::make($request->all(), $validationArray);
        $toData = User::where('id', $request->to)->first();
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {
            $user = Auth::user();
            if($user->id == $request->to){
                $response["message"] =  "Sorry Please Check Receiver's Number";
                return response()->json($response,422);
            }

            if($user->college_id == $toData->college_id && $user->class_id == $toData->class_id){
                $response["message"] = "Sorry You can not send request in same class Student";
                return response()->json($response,422);
            }

             $channel = Channel::where(function ($q) use ($request, $user) {
                 $q->where(function ($query) use ($request, $user) {
                     $query->where('to_user_id', $request->to)
                         ->where('from_user_id', $user->id);
                 })->orWhere(function ($query) use ($request, $user) {
                     $query->where('to_user_id', $user->id)
                         ->where('from_user_id', $request->to);
                 });
             })->first();



            if ($channel == null) {
                $channel = new Channel();
                $channel->to_user_id = $request->to;
                $channel->from_user_id = $user->id;
                $channel->time = time();
                $channel->save();
                $channel_id = $channel->id;
            }else{
                $channel_id = $channel->id;

                if($channel->from_user_id == $request->to){
                    if($channel->request == 'a'){
                        $alreadySendR['accept'] = array();
                        array_push($alreadySendR['accept'], "Booth of you are already approved. ");
                        $response['message'] = "errors";
                        $response['errors'] = $alreadySendR;
                        $response['errors_key'] = array_keys($alreadySendR);
                        return response()->json($response, 422);
                    }
                    $alreadySendR['Request'] = array();
                    array_push($alreadySendR['Request'], "You have Already Received the Reaquest, Plese accept it. ");
                    $response['message'] = "errors";
                    $response['errors'] = $alreadySendR;
                    $response['errors_key'] = array_keys($alreadySendR);
                    return response()->json($response, 422);

                }else{
                    if($channel->to_user_id == $request->to){

                        $alreadySendR['Request'] = array();
                        array_push($alreadySendR['Request'], "You have Already Send the Request, Please wait for his Acceptance.  ");
                        $response['message'] = "errors";
                        $response['errors'] = $alreadySendR;
                        $response['errors_key'] = array_keys($alreadySendR);
                        return response()->json($response, 422);

                    }

                }


            }

            $channel_id = $channel->id;
            $notification = new Notification();
            $notification->channel_id = $channel_id;
            $notification->user_id = $user->id;
            $notification->to_user_id = $request->to;
            $notification->type = 'Request';
            $notification->title= 'Friend Requests.';
            $notification->description = 'You have Received a new Friend Requests.';
            $notification->time = time();
            $notification->save();

            $response['message'] = " The Request has been send Sucessfully.";
            return response()->json($response, 200);
        }

    }

    public function acceptRequest(Request $request){
        $validationArray = array();
        $validationArray['to'] = 'required|exists:users,id';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {
            $user = Auth::user();
            $channel = Channel::where('to_user_id',$user->id)->where('from_user_id',$request->to)->where('request','d')->first();

            $alreadyApprove = Channel::where('to_user_id',$user->id)->where('from_user_id',$request->to)->where('request','a')->first();

            if($alreadyApprove ==null){

            }else{
                $validApprover['Request'] = array();
                array_push($validApprover['Request'], " You have Already Accept the Request");
                $response['message'] = "errors";
                $response['errors'] = $validApprover;
                $response['errors_key'] = array_keys($validApprover);
                return response()->json($response, 422);
            }


            if($channel ==null){
                $validApprover['Request'] = array();
                array_push($validApprover['Request'], " Sorry you have not send a request.");
                $response['message'] = "errors";
                $response['errors'] = $validApprover;
                $response['errors_key'] = array_keys($validApprover);
                return response()->json($response, 422);
            }

            if($channel->to_user_id == $user->id && $channel->from_user_id == $request->to){
                $accept  = array(
                    'request' => 'a',
                );
                Channel::where('to_user_id',$user->id)->where('from_user_id',$request->to)->update($accept);

                $readnotification = array(
                    'status' =>'r',
                );
                Notification::where('user_id',$request->to)->where('to_user_id',$user->id)->update($readnotification);

                $response['message'] = " The Request has been accepted .";
                return response()->json($response, 200);
            }
        }
    }

    public function deleteRequest(Request $request){

        $validationArray = array();
        $validationArray['to'] = 'required|exists:users,id';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {
            $user = Auth::user();

            $channel = Channel::where(function ($q) use ($request, $user) {
                $q->where(function ($query) use ($request, $user) {
                    $query->where('from_user_id', $user->id)
                        ->where('to_user_id', $request->to);
                })->orWhere(function ($query) use ($request, $user) {
                    $query->where('to_user_id', $user->id)
                        ->where('from_user_id', $request->to);
                });
            })->first();

            if($channel ==null){
                $validApprover['Request'] = array();
                array_push($validApprover['Request'], "Sorry you have not send or received a request.");
                $response['message'] = "errors";
                $response['errors'] = $validApprover;
                $response['errors_key'] = array_keys($validApprover);
                return response()->json($response, 422);
            }
            if($channel->request == 'd'){
                $channel->delete();
                $response['message']=" Request Deleted Sucessfully";
                return response()->json($response, 200);
            }else{
                $deleteRequest['Delete'] = array();
                array_push($deleteRequest['Delete'], " Sorry Request has been accepted .You can not delete after accept ");
                $response['message'] = "errors";
                $response['errors'] = $deleteRequest;
                $response['errors_key'] = array_keys($deleteRequest);
                return response()->json($response, 422);
            }


        }
    }

    public function getChannelId(Request $request){

        $validationArray = array();
        $validationArray['to'] = 'required|exists:users,id';
        $validator = Validator::make($request->all(), $validationArray);

        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        } else {
            $user = Auth::user();
            if ($user->id == $request->to) {
                $response["message"] = "Sorry Please Check Receiver's Number";
                return response()->json($response, 422);
            }
            $toData = User::where('id', $request->to)->first();
            $channel = Channel::where(function ($q) use ($request, $user) {
                $q->where(function ($query) use ($request, $user) {
                    $query->where('to_user_id', $request->to)
                        ->where('from_user_id', $user->id);
                })->orWhere(function ($query) use ($request, $user) {
                    $query->where('to_user_id', $user->id)
                        ->where('from_user_id', $request->to);
                });
            })->first();


            if($channel == null){
                if ($user->college_id != $toData->college_id || $user->class_id != $toData->class_id) {
                    $invalidCollege['user'] = array();
                    array_push($invalidCollege['user'], "Sorry This Student is not in your Class or College. If you Want to Chat with him. please send Request.");
                    $response['message'] = "errors";
                    $response['errors'] = $invalidCollege;
                    $response['errors_key'] = array_keys($invalidCollege);
                    return response()->json($response, 422);
                }


                $channel_ins = new Channel();
                $channel_ins->to_user_id = $request->to;
                $channel_ins->from_user_id = $user->id;
                $channel_ins->request = 'a';
                $channel_ins->time = time();
                $channel_ins->save();

                $sameUser['id'] = $channel_ins->id;
                $response['message'] = "Channel Id ";
                $response['id'] = $sameUser;
                return response()->json($response, 200);




            }

            $channel_id = $channel->id;
            $sameUser['id'] = $channel_id;
            $response['message'] = "Channel id ";
            $response['id'] = $sameUser;
            return response()->json($response, 200);




        }
    }

    public function getAllMessages(Request $request){

        $validationArray = array();
        $validationArray['channel_id'] = 'required|exists:chat,channel_id';
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());

            return response()->json($response, 422);
        } else {
            $user = Auth::user();
            $messages = Chat::where('channel_id', $request->channel_id)->get()->toArray();

            $sameUser['success'] = $messages;
            $response['message'] = "Message List ";
            $response['success'] = $sameUser;
            $response['code']=200;
            return response()->json($response, 200);
        }

    }

    public function recentChat(Request $request){

        $validationArray = array();
//        $validationArray['to'] = 'required| exists:chat';
        $validator = Validator::make($request->all(),$validationArray);
        if($validator->fails()){
            $response['message'] = 'errors';
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return $response()->json($response, 422);

        }else{
            $user = Auth::user();

//            $recentChats = Chat::selectRaw('user_id, to_user_id,id,message,created_at, user_id * to_user_id as ch')->where('to_user_id',$user->id)->orWhere('user_id',$user->id)->groupby('ch')->get();


  /*          $check = DB::table('chat')->select(DB::raw(" user_id,to_user_id,message,created_at")->where('user_id',$user->id)->orWhere('to_user_id',$user->id)."AND id = ".SELECT chat1.id FROM chat as chat1 where chat1.channel_id = chat.channel_id ORDER BY id DESC LIMIT 1) GROUP BY `channel_id` ORDER BY chat.id DESC")->get();

            dd($check);*/
/*SELECT * FROM `chat` WHERE (`user_id` = 7 OR `to_user_id` = 7) AND `id` = (SELECT chat1.id FROM chat as chat1 where chat1.channel_id = chat.channel_id ORDER BY id DESC LIMIT 1) GROUP BY `channel_id` ORDER BY chat.id DESC*/
/*

            $recentChats =  Chat::selectRaw('user_id,to_user_id,message,created_at')->where('user_id',$user->id)->orWhere('to_user_id',$user->id)
              ->where('id','SELECT chat1.id FROM chat as chat1 where chat1.channel_id = chat.channel_id ORDER BY id DESC LIMIT 1)')->groupBy('channel_id')->orderBy('chat.id','desc')->get();*/

//            $recentChats = DB::SELECT("SELECT * FROM `chat` WHERE (`user_id` = ".$user->id." OR `to_user_id` = ".$user->id.") AND
//`id` = (SELECT chat1.id FROM chat as chat1 where chat1.channel_id = chat.channel_id ORDER BY id DESC LIMIT 1) GROUP BY `channel_id`  ORDER BY chat.id DESC");

            $recentChats =  Chat::selectRaw('chat.id,user_id,to_user_id,message,created_at')
                ->where('user_id',$user->id)
                ->whereRaw('id = (SELECT chat1.id FROM chat as chat1 where chat1.channel_id = chat.channel_id ORDER BY id DESC LIMIT 1)')->orWhere('to_user_id',$user->id)
                ->whereRaw('id = (SELECT chat1.id FROM chat as chat1 where chat1.channel_id = chat.channel_id ORDER BY id DESC LIMIT 1)')->groupBy('channel_id')->orderBy('chat.id','desc')->get();
////            dd($recentChats);
//
            foreach ($recentChats as $recentChat){
                if($recentChat->user_id == $user->id){
                    $recentChat->user = $recentChat->getToUser;
                }else {
                    $recentChat->user = $recentChat->getFromUser;
                }
            }

//            $recent['success'] = $rec;
            $response['message'] = "recent send chat ";
            $recent['recent_send_chat'] = $recentChats;
            $response['message'] = "recent received chat ";

            $recent["UserMain"]= $user;
            $response['sucess']= $recent;

            $response['code']=200;
            return response()->json($response, 200);

        }
    }

    public function requestList(Request $request){
        $validationArray = array();
//        $validationArray['to'] = 'required| exists:chat';
        $validator = Validator::make($request->all(),$validationArray);
        if($validator->fails()){
            $response['message'] = 'errors';
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return $response()->json($response, 422);

        }else {
            $user = Auth::user();

            $requestList = Channel::with('getToUser')->where('to_user_id',$user->id)->where('request','d')->get();


            $sameUser['success'] = $requestList;
            $response['message'] = "Message List ";
            $response['success'] = $sameUser;
            $response['code']=200;
            return response()->json($response, 200);
        }

        }

    public function notificationToken(Request $request){
        $user = Auth::user();
        $validationArray = array();
        $validationArray['fcm_token'] = 'required';
        $validator = Validator::make($request->all(), $validationArray);

        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);

        } else {

            $user = User::where('id', $user->id)->first();
            $fcm_token = array(
                'fcm_token' => $request->fcm_token,
            );
            User::where('id', $user->id)->update($fcm_token);

            $response['message'] = " Fcm_token Add sucessfully .";
            return response()->json($response, 200);
        }
    }

    public function deletePost(Request $request){

        Auth::user();
        $validatonArray = array();
        $validatonArray['post_id']='required';
        $validator=Validator::make($request->all(),$validatonArray);
        if($validator->fails()){
            $response['message']='errors';
            $response['errors']=$validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        }else{

            $postData=CollegePost::where('id',$request->post_id)->first();
            if(empty($postData)){
                $response['message']='This post id is not exist or invalid ';
                return response()->json($response, 400);
            }

            if ($postData->user_id == Auth::user()->id){
                CollegePost::where('id',$request->post_id)->delete();
                PostComment::where('post_id',$request->post_id)->delete();
                RepliedComment::where('post_id',$request->post_id)->delete();
                $response['message']= 'Your Post sucessfully delete.';
                return response()->json($response, 200);

            }else{
                $response['message']='Sorry you can not delete this post because of this is not your post';
                return response()->json($response, 400);
            }

        }
    }
}
