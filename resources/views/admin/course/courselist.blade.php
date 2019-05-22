@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>All Course List</h1>

@stop

@section('content')

        @if(Session::has('message'))
            <div class="alert alert-success"> {{Session::get('message')}}</div>

        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger"> {{Session::get('error')}}</div>

        @endif


        <div class="table-responsive">
        <table id="courseTable" class="table">
            <thead>
            <tr >
                <th>
                    S.no
                </th>
                <th>
                     Course Name
                </th>
                <th>
                    Course Description
                </th>
                <th>
                    Taught By
                </th>
                <th>
                    Course Duration
                </th>
                <th>
                    Prerequisites
                </th>
                <th>
                    created_at
                </th>
                <th>
                    updated_at
                </th>

                <th>
                    Operations
                </th>
                <th>
                    View Videos
                </th>
            </tr>
            </thead>
            <tbody>

            @if(count($sublist)>0)
                @foreach($sublist as $key => $value)
                    <tr>
                        <td>
                            {{$loop->index+1}}
                        </td>
                        <td style=" word-break: break-all;">
                            {{$value->course}}
                        </td>
                        <td style=" word-break: break-all;">
                            {{$value->course_description}}
                        </td>
                        <td style=" word-break: break-all;">
                            {{$value->taughtby}}
                        </td>
                        <td>
                            {{$value->course_duration}}
                        </td>
                        <td style=" word-break: break-all;">
                            {{$value->prerequisites}}
                        </td>

                        <td>
                            {{$value->created_at}}
                        </td>
                        <td>
                            {{$value->updated_at}}
                        </td>

                        <td>
                            <a href="{{route('deletecourse',$value->id)}}" class="btn btn-danger" onclick="return confirm('All Data will delete which is associate with this course(like course, subject, video Details)\n \n \nYou Want to Delete. ');">Delete</a>
                            <br><br>

                            <a href="{{route('updatecourse',$value->id)}}" class="btn btn-success">Update</a>
                        </td>
                        <td>
                            <a  href="{{route('videolist',$value->id)}}"class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            @endif



            </tbody>
        </table>
    </div>

@stop



