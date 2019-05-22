<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/read','User\UserController@read')->middleware('auth:api');

Route::post('/register','RegisterController@register');         //REGISTER CONTROLLER WHICH IS CONTROLLER FOLDER

Route::post('/login','User\UserLoginController@login');         //USER CONTROLLER LOGIN IN USER FOLDER

Route::get('/colleges','College\CollegeController@colleges');                              //College FOLDER

Route::post('/classes','College\CollegeController@collegeclasses');                       //College FOLDER

Route::post('/subject','Classes\ClassesController@subject')->middleware('auth:api');                           //Classes FOLDER

Route::post('/course','Subject\SubjectController@course')->middleware('auth:api');                             //Subject FOLDER

Route::post('/course-detail','Course\CourseController@coursedetail')->middleware('auth:api');                   //Course FOLDER

Route::post('/college-post','College\CollegeController@collegepost')->middleware('auth:api');                  //College FOLDER

Route::post('/comments-on-post','College\CollegeController@comments')->middleware('auth:api');                //College FOLDER

Route::Post('/student-post','College\CollegeController@studentPost')->middleware('auth:api');              //College FOLDER

Route::post('/post-comment','College\CollegeController@postComment')->middleware('auth:api');             //College FOLDER

Route::post('/forgot-password-otp','User\UserLoginController@forgotpassword');

Route::post('/verify-otp','User\UserLoginController@vefifyOtp');

Route::post('/update-password','User\UserLoginController@updatePassword');

Route::post('/class-users','User\UserController@classUsers')->middleware('auth:api');

Route::post('/college-users','College\CollegeController@collegeUsers')->middleware('auth:api');

Route::post('/get-profile','User\UserController@getProfile')->middleware('auth:api');

Route::post('/update-profile','User\UserController@updateProfile')->middleware('auth:api');

//------------------------------chat APi's'-----------------------------------------------------------

Route::post('/send-request','Chats\ChatController@sendRequest')->middleware('auth:api');

Route::post('/send-message','Chats\ChatController@sendMessage')->middleware('auth:api');

Route::post('/accept-request','Chats\ChatController@acceptRequest')->middleware('auth:api');

Route::post('/delete-request','Chats\ChatController@deleteRequest')->middleware('auth:api');

Route::post('/get-channel-id','Chats\ChatController@getChannelId')->middleware('auth:api');

Route::post('/get-all-messages','Chats\ChatController@getAllMessages')->middleware('auth:api');

Route::post('/recent-chat','Chats\ChatController@recentChat')->middleware('auth:api');

Route::post('/request-list','Chats\ChatController@requestList')->middleware('auth:api');

Route::post('/notification-token','Chats\ChatController@notificationToken')->middleware('auth:api');



Route::post('/view-student-profile','User\UserController@viewStudentProfile')->middleware('auth:api');

Route::post('/reply-on-comment','User\UserController@replyOnComment')->middleware('auth:api');

Route::post('/delete-post','Chats\ChatController@deletePost')->middleware('auth:api');




