@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>All Classes List</h1>
@stop

@section('content')
    <div>
        @if(Session::has('message'))
            <div class="alert alert-success"> {{Session::get('message')}}</div>

        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger"> {{Session::get('error')}}</div>

        @endif
            <div class="table-responsive">
                <table name="classlist" class="table">
            <thead>
            <tr >
                <th>
                    S.no
                </th>
                <th>
                    College Name
                </th>

                <th>
                    class
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
                    View Subjects
                </th>
            </tr>
            </thead>
            <tbody>
            @if(count($clslist)>0)

                @foreach($clslist as $key => $value)

                    <tr>
                        <td>
                            {{$loop->index+1}}
                        </td>
                        <td>
                            {{$value->college->college}}
                        </td>

                        <td>
                            {{$value->class}}
                        </td>
                        <td>
                            {{$value->created_at}}
                        </td>
                        <td>
                            {{$value->updated_at}}
                        </td>

                        <td>

                            <a href="{{route('deletecls',$value->id)}}" class="btn btn-danger" onclick="return confirm('All Data will delete which is associate with this class(like class, course, subject)\n \n \nYou Want to Delete. ');">Delete</a>


                            <a href="{{route('updatecls',$value->id)}}" class="btn btn-success">Update</a>
                        </td>
                        <td>
                            <a href="{{route('subjectlist',$value->id)}}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach

            @endif

            </tbody>
        </table>
            </div>
    </div>

@stop
