<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Middleware\SubAdminMiddleware;
Route::get('/', 'Admin\LoginController@showLoginForm');

Route::post('admin/login','Admin\LoginController@login');

Route::post('admin/logout','Admin\LoginController@logout');

Route::get('admin/home','Admin\DashboardController@index')->name('home');

Route::get('password/reset','Admin\LoginController@passwordreset');

//Route::get('collegelist','Admin\DashboardController@collegeregister');
Route::prefix('college')->group(function (){

    Route::get('college-list','College\CollegeController@collegelist')->name('collegelist');
    Route::get('college-form','College\CollegeController@collegeform')->name('collegeform');
    Route::post('college-form','College\CollegeController@registerclg')->name('registerclg');
    Route::get('delete-clg/{id}','College\CollegeController@deleteclg')->name('deleteclg');
    Route::get('update-clg/{id}','College\CollegeController@updateclg')->name('updateclg');
    Route::post('college-update','College\CollegeController@updatecollegeData')->name('updatecollegeData');


});

Route::prefix('class')->group(function(){

        Route::get('class-list','Classes\ClassesController@classlist')->name('classlist');
        Route::get('classes-list/{id?}','Classes\ClassesController@classeslist')->name('classeslist');
        Route::get('delete-cls/{id}','Classes\ClassesController@deletecls')->name('deletecls');
        Route::get('update-cls/{id}','Classes\ClassesController@updatecls')->name('updatecls');
        Route::post('class-update','Classes\ClassesController@updateclassData')->name('updateclassData');
        Route::get('add-class','Classes\ClassesController@addclass')->name('addclass');
        Route::post('add-class','Classes\ClassesController@registercls')->name('registercls');
});

Route::prefix('subject')->group(function (){

    Route::get('subject-list/{id?}','Subject\SubjectController@subjectlist')->name('subjectlist');
    Route::get('delete-subject/{id}','Subject\SubjectController@deletesubject')->name('deletesubject');
    Route::get('update-subject/{id}','Subject\SubjectController@updatesubject')->name('updatesubject');
    Route::post('update-subject-Data','Subject\SubjectController@updatesubjectData')->name('updatesubjectData');
    Route::get('add-subject','Subject\SubjectController@addsubject')->name('addsubject');
    Route::get('class-fetch/{id}','Subject\SubjectController@classfetch')->name('classfetch');
    Route::post('register-subject','Subject\SubjectController@registersubject')->name('registersubject');

});

Route::prefix('course')->group(function(){

    Route::get('course-list/{id?}','Course\CourseController@courselist')->name('courselist');
    Route::get('delete-course/{id}','Course\CourseController@deletecourse')->name('deletecourse');
    Route::get('update-course/{id}','Course\CourseController@updatecourse')->name('updatecourse');
    Route::post('update-course-Data','Course\CourseController@updatecourseData')->name('updatecourseData');
    Route::get('add-course','Course\CourseController@addcourse')->name('addcourse');
    Route::get('class-fetch/{id}','Course\CourseController@classfetch')->name('classfetch');
    Route::get('subject-fetch/{id}','Course\CourseController@subjectfetch')->name('subjectfetch');
    Route::post('register-course','Course\CourseController@registercourse')->name('registercourse');
});

Route::prefix('video')->group(function (){

   Route::get('video-list/{id?}','Video\VideoController@videolist')->name('videolist');
    Route::get('add-video','Video\VideoController@addvideo')->name('addvideo');
    Route::post('upload-video','Video\VideoController@uploadvideo')->name('uploadvideo');
    Route::get('delete-video/{id}','Video\VideoController@deletevideo')->name('deletevideo');
    Route::get('update-video/{id}','Video\VideoController@updatevideo')->name('updatevideo');
    Route::post('update-video','Video\VideoController@updatevideoData')->name('updatevideoData');
    Route::get('class-fetch/{id}','Video\VideoController@classfetch')->name('classfetch');
    Route::get('subject-fetch/{id}','Video\VideoController@subjectfetch')->name('subjectfetch');
    Route::get('course-fetch/{id}','Video\VideoController@coursefetch')->name('coursefetch');
    Route::get('view-video/{id}','Video\VideoController@viewvideo')->name('viewvideo');

});

Route::prefix('student')->group(function (){

   Route::get('approved-student-list','User\UserController@approvedstudentlist')->name('approvedstudentlist');
    Route::get('student-details/{id}','User\UserController@studentdetails')->name('studentdetails');
    Route::get('disapprove-student-list','User\UserController@notapprovestudentlist')->name('notapprovestudentlist');
    Route::get('approvel/{id}','User\UserController@approvel')->name('approvel');
});

Route::prefix('classrepresentative')->group(function (){

    Route::get('sub-admin-list','SubAdmin\SubAdminController@subAdminList')->name('subAdminList');
    Route::get('add-sub-admin','SubAdmin\SubAdminController@addSubAdmin')->name('addSubAdmin');
    Route::post('make-sub-admin','SubAdmin\SubAdminController@makeSubAdmin')->name('makeSubAdmin');
    Route::get('delete-sub-admin/{id}','SubAdmin\SubAdminController@deleteSubAdmin')->name('deleteSubAdmin');
    Route::get('update-sub-admin/{id}','SubAdmin\SubAdminController@updateSubAdmin')->name('updateSubAdmin');
    Route::get('class-fetch/{id}','SubAdmin\SubAdminController@classfetch')->name('classfetch');
    Route::post('Update-Sub-Admin-Data','SubAdmin\SubAdminController@updatesubadminData')->name('updatesubadminData');
});

Route::get('/login', function(){
    return redirect('/');
})->name('login');
