@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>All Subjects List</h1>

@stop

@section('content')

    @if(Session::has('message'))
        <div class="alert alert-success"> {{Session::get('message')}}</div>

    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger"> {{Session::get('error')}}</div>

    @endif



    <div class="table-responsive">
        <table name="subjecttable" id="myTable"class="table">
        <thead>
        <tr >
            <th>
                S.no
            </th>

            <th>
                College Name
            </th>
            <th>
                Class Name
            </th>
            <th>
                Subject
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
                View Course
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
                    <td>
                        {{$value->college->college}}
                    </td>
                    <td>
                        {{$value->classes->class}}
                    </td>
                    <td>
                        {{$value->subject}}
                    </td>

                    <td>
                        {{$value->created_at}}
                    </td>
                    <td>
                        {{$value->updated_at}}
                    </td>
                    <td>
                        <a href="{{route('deletesubject',$value->id)}}" class="btn btn-danger" onclick="return confirm('All Data will delete which is associate with this subject(like course, subject, video Details)\n \n \nYou Want to Delete. ');">Delete</a>
                        <br><br>

                        <a href="{{route('updatesubject',$value->id)}}" class="btn btn-success">Update</a>
                    </td>
                    <td>
                        <a href="{{route('courselist',$value->id)}}"class="btn btn-info">View</a>
                    </td>

                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    </div>


@stop

