<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
            $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

                if(Auth::guard('admin')->user()->sub_admin_flag == "subadmin"){
                    $event->menu->add('MAIN NAVIGATION');
                    $event->menu->add([
                        'text' => 'Manage Students',
                        'icon' => 'user',
                        'submenu' =>[
                            [
                                'text' =>'View Approved Students',
                                'url'  => 'student/approved-student-list',
                                'icon' => 'eye',

                            ],
                            [
                                'text'=>'View Disapprove Student',
                                'url'=>'student/disapprove-student-list',
                                'icon'=>'eye',
                            ],
                        ],
                    ]);
                }else{
                    $event->menu->add('MAIN NAVIGATION');
                    $event->menu->add([
                        'text'  =>'Dashboard',
                        'url'   =>'admin/home',
                        'icon'  =>'dashboard',
                        'active' => ['admin'],
                    ]);
                    $event->menu->add('OPERATIONS');
                    $event->menu->add([

                        'text' => 'Manage Students',
                        'icon' => 'group',

                        'submenu' =>[
                            [
                                'text' =>'View Approved Students',
                                'url'  => 'student/approved-student-list',
                                'icon' => 'eye',
                            ],
                            [
                                'text'=>'View Disapprove Student',
                                'url'=>'student/disapprove-student-list',
                                'icon'=>'eye',
                            ],
                        ],

                    ]);
                    $event->menu->add([
                                'text' => 'Manage Sub Admin',
                                'icon' => 'child',
                                'submenu' =>[
                            [
                                'text' =>'View All Sub Admin',
                                'url'  => 'classrepresentative/sub-admin-list',
                                'icon' => 'eye',

                             ],
                            [
                                'text'=>'Add Sub Admin',
                                'url'=>'classrepresentative/add-sub-admin',
                                'icon'=>'plus',
                             ],
                             ],

                    ]);
                    $event->menu->add([
                        'text'  =>'Manage Colleges',
                        'icon'  =>'building',
                        'submenu' => [
                            [
                                'text' => 'View College',
                                'url'  => 'college/college-list',
                                'icon' =>'eye',
                            ],

                            [
                                'text' => 'Add College',
                                'url'  => 'college/college-form',
                                'icon' =>'plus',
                            ],

                         ],
                    ]);
                    $event->menu->add([
                        'text' => 'Manage Classes',
                        'icon' => 'user',
                        'submenu' =>[
                            [
                                'text' =>'View Classes',
                                'url'  => 'class/classes-list',
                                'icon' => 'eye',

                            ],
                            [
                                'text'=>'Add Classes',
                                'url'=>'class/class-list',
                                'icon'=>'plus',
                            ],
                        ],
                    ]);
                    $event->menu->add([
                        'text' => 'Manage Subjects',
                        'icon' => 'copy',
                        'submenu' =>[
                            [
                                'text' =>'View Subject',
                                'url'  => 'subject/subject-list',
                                'icon' => 'eye',

                            ],
                            [
                                'text'=>'Add Subject',
                                'url'=>'subject/add-subject',
                                'icon'=>'plus',
                            ],
                        ],

                    ]);
                    $event->menu->add([
                        'text' => 'Manage Courses',
                        'icon' => 'book',
                        'submenu' =>[
                            [
                                'text' =>'View Courses',
                                'url'  => 'course/course-list',
                                'icon' => 'eye',

                            ],
                            [
                                'text'=>'Add Course',
                                'url'=>'course/add-course',
                                'icon'=>'plus',
                            ],
                        ],
                    ]);
                    $event->menu->add([
                        'text' => 'Manage Videos',
                        'icon' => 'video-camera',
                        'submenu' =>[
                            [
                                'text' =>'Video List',
                                'url'  => 'video/video-list',
                                'icon' => 'eye',

                            ],
                            [
                                'text'=>'Add Videos',
                                'url'=>'video/add-video',
                                'icon'=>'plus',
                            ],
                        ],
                    ]);
                }
            });
//        }

        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
