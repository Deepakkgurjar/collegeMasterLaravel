<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

class RegisterController extends Controller{

    public function register(Request $request){
        $validationArray = array();
        $validationArray['virtual_name']='required';
        $validationArray['name']='required';
        $validationArray['college_id']='required';
        $validationArray['class_id']='required';
        $validationArray['year']='required';
        $validationArray['email']='required|unique:users';
        $validationArray['password']='required';
        $validationArray['id_card']='required|mimes:jpeg,bmp,png';
        $validator=Validator::make($request->all(),$validationArray);
        if ($validator->fails()){
            $response['message']="errors";
            $response['errors']=$validator->errors()->toArray();
            $response['errors_key']=array_keys($validator->errors()->toArray());
            return response()->json($response,422);
        }else{
            if($request->file('id_card')){
                $file = $request->file('id_card');
                $filename=time().'.'.$file->getClientOriginalExtension();
                $file->move("storage/image/idimages/",$filename);
                $path_id = 'storage/image/idimages/'.$filename;
            }
            $user = new User;
            $user->virtual_name = $request->virtual_name;
            $user->name = $request->name;
            $user->college_id= $request->college_id;
            $user->class_id = $request->class_id;
            $user->year = $request->year;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->id_card = $path_id;
            $user->api_token= sha1(time());
            $user->save();
            //dd($user->id,"Data successfully Added");
            if (!empty($user)) {
                $response['message']="Congratulations you are sucessfully registered, Wait until Admin Approval for Course Access.";
                return response()->json($response,200);
            } else {
                $response['message']="OOPS! Something went Wrong!!";
                return response()->json($response, 400);
            }
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
