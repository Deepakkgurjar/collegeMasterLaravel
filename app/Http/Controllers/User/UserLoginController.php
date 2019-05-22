<?php

namespace App\Http\Controllers\User;
use App\Mail\ForgotOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\ForgotPassword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserLoginController extends Controller
{
    public function login(Request $request){
        $validationArray = array();
        $validationArray['email']='required';
        $validationArray['password']='required';
        $validator=Validator::make($request->all(),$validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        }else{
            $userData = User::where('email',$request->email)->with("getcollege","getclass")->first();
            if (!empty($userData)) {
                if($userData->verify != 'y'){
                    $respond['message'] = "Sorry! you can not Access your Account without Admin Approval. Please Wait Some Time for Admin Approval or Contact to Admin";
                    return response()->json($respond, 422);
                }
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    $respond['message'] = "Sucessfully Login.Welcome";
                    $respond['data'] = $userData;
                    return response()->json($respond, 200);
                } else {
                    $respond['message'] = "You entered wrong password. Please Check your Password.";
                    return response()->json($respond, 400);
                }
            }else{
                $respond['message']="Your Email is wrong. Please Check your Email Id.";
                return response()->json($respond, 422);
            }
        }
    }

    public function forgotpassword(Request $request){

        $validationArray = array();
        $validationArray['email']='required';
        $validator=Validator::make($request->all(),$validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        }else {
            $userData = User::where('email', $request->email)->first();
            if (!empty($userData)) {

                    $length = 6;
                $otp = "";
                    $codeAlphabet = "0123456789";
                    $max = strlen($codeAlphabet); // edited
                    for ($i = 0; $i < $length; $i++) {
                        $otp .= $codeAlphabet[random_int(0, $max - 1)];
                    }


//                    $forgot = ForgotPassword::where('otp', $otp)->first();
//                    if (!empty($forgot) && $forgot->otp !=$otp) {
//
//                        $respond['message'] = "Please Regenerate your password";
//                        return response()->json($respond, 400);
//
//                    } else {
                        $otpCount = ForgotPassword::where('email', $request->email)->where('time','>=',strtotime('today midnight'))->where('time','<=',time())->count();
                        if($otpCount < 5){
                            $forgot_password = new ForgotPassword();
                            $forgot_password->otp = $otp;
                            $forgot_password->verifyed = 'n';
                            $forgot_password->email = $request->email;
                            $forgot_password->time = time();
                            $forgot_password->save();

                            Mail::to($request->email)->send(new ForgotOtp($request->email, $otp));
                            $respond['message'] = " OTP Sucesfully Generate ";

                            return response()->json($respond, 200);
                        }else{
                            $respond['message'] = "You exceed limit of sending otp,you blocked for a day";
                            return response()->json($respond, 422);
                        }


//                    }

                } else {
                    $respond['message'] = "Your Email is wrong. Please Check your Email Id.";
                    return response()->json($respond, 422);
                }
            }
        }

    public function vefifyOtp(Request $request){
        $validationArray = array();
        $validationArray['email']='required';
        $validationArray['otp'] = 'required';

        $validator=Validator::make($request->all(),$validationArray);
        if ($validator->fails()) {
            $response['message'] = "errors";
            $response['errors'] = $validator->errors()->toArray();
            $response['errors_key'] = array_keys($validator->errors()->toArray());
            return response()->json($response, 422);
        }else {

            $userData = User::where('email', $request->email)->first();

            if(empty($userData)){
                $respond['message'] = "Email not exist or invalid";
                return response()->json($respond, 400);
            }
            $verifyed = ForgotPassword::where('email',$request->email)->where('otp',$request->otp)->first();
            if (!empty($verifyed) ) {

                    ForgotPassword::where('email',$request->email)->where('otp',$request->otp)->update(array('verifyed'=>'y'));
                    ForgotPassword::where('email',$request->email)->delete();
                    $respond['message'] = "sucessfully verifyed";
                $respond['api-Token']=$userData->api_token;
                    return response()->json($respond, 200);

            }else{
                $respond['message'] = "Your Entered wrong otp.";
                return response()->json($respond, 400);
            }

        }
    }

    public function updatePassword(Request $request){

        $validationArray = array();
        $validationArray['api_token'] = 'required';
        $validationArray['password'] = 'required';
        $validationArray['conformPassword']='required';

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

                if($request->password == $request->conformPassword){
                    $updatePass =  array(
                        "password" => Hash::make($request->password),
                    );
                    User::where('api_token',$request->api_token)->update($updatePass);
                    $respond['message'] = "Password Update sucessfully.";
                    return response()->json($respond, 200);

                }else{
                    $respond['message'] = "message','Password Does not Match.";
                    return response()->json($respond, 400);

                }

            }
        }
    }
}
