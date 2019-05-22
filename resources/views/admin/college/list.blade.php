@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')

    <h1>College List</h1>
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
                <table name="collegetable" id="myTable"class="table">
            <thead>
            <tr >
                <th>
                    S.no
                </th>
                <th>
                    college id
                </th>
                <th>
                    college
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
                    View Classes
                </th>
            </tr>
            </thead>
            <tbody>
            @if(count($colleges)>0)
                @foreach($colleges as $key => $value)
                    <tr>
                        <td>
                            {{$loop->index+1}}
                        </td>
                        <td>
                            {{$value->id}}
                        </td>
                        <td>
                            {{$value->college}}
                        </td>
                        <td>
                            {{$value->created_at}}
                        </td>
                        <td>
                            {{$value->updated_at}}
                        </td>

                        <td>
                            <a href="{{route('deleteclg',$value->id)}}" class="btn btn-danger"onclick="return confirm('All Data will delete which is associate with this college(like college, class, course, subject)\n \n \nYou Want to Delete. ');">Delete</a>

                            <a href="{{route('updateclg',$value->id)}}" class="btn btn-success fas fa-edit"> Update</a>
                        </td>
                        <td>
                            <a href="{{route('classeslist',$value->id)}}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>
            </div>
    </div>

@stop

