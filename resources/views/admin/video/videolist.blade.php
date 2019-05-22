@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>All Video List</h1>

@stop

@section('content')

    @if(Session::has('message'))
        <div class="alert alert-success"> {{Session::get('message')}}</div>

    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger"> {{Session::get('error')}}</div>

    @endif

    <div class="table-responsive">
        <table name="videotable" id="myTable"class="table">
        <thead>
        <tr >
            <th>
                S.no
            </th>

            <th>
                Course
            </th>
            <th>
                Title
            </th>
            <th>
                Video Description
            </th>

            <th>
                Video
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
                View Video
            </th>
        </tr>
        </thead>
        <tbody>

        @if(count($videolist)>0)
            @foreach($videolist as $key => $value)
                <tr>
                    <td>
                        {{$loop->index+1}}
                    </td>
                    <td style=" word-break: break-all;">
                        {{$value->course->course}}
                    </td>
                    <td style=" word-break: break-all;">
                        {{$value->title}}
                    </td>
                    <td style=" word-break: break-all;">
                        {{$value->video_description}}
                    </td>
                    <td style=" word-break: break-all;">
                        {{$value->video}}
                    </td>

                    <td>
                        {{$value->created_at}}
                    </td>
                    <td>
                        {{$value->updated_at}}
                    </td>
                    <td>
                        <a href="{{route('deletevideo',$value->id)}}"class="btn btn-danger" onclick="return confirm('Do you want to Delete This Video. ');">Delete</a>
                        <br><br>

                        <a href="{{route('updatevideo',$value->id)}}"class="btn btn-success">Update</a>
                    </td>
                    <td>
                        <a href="{{route('viewvideo',$value->id)}}"class="btn btn-info">View</a>
                    </td>

                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    </div>




@stop

