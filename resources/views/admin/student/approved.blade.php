@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Approved Class Student List</h1>
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
                <table name="approve_student" id="myTable" class="table">
            <thead>
            <tr >
                <th>
                    S.no
                </th>
                <th>
                    Name
                </th>
                <th>
                    College Name
                </th>

                <th>
                    class
                </th>
                <th>
                    Year
                </th>
                <th>
                    Approved By
                </th>
                <th>
                    created_at
                </th>

                <th>
                    updated_at
                </th>

                <th>
                    View Details
                </th>
            </tr>
            </thead>
            <tbody>
            @if(count($approvedstudent)>0)
                @foreach($approvedstudent as $key => $value)

                    <tr>
                        <td>
                            {{$loop->index+1}}
                        </td>
                        <td>
                            {{$value->name}}
                        </td>
                        <td>
                            {{$value->college->college}}
                        </td>

                        <td>
                            {{$value->classes->class}}
                        </td>
                        <td>
                            {{$value->year}}
                        </td>
                        <td>
                            {{$value->approved_by}}
                        </td>
                        <td>
                            {{$value->created_at}}
                        </td>
                        <td>
                            {{$value->updated_at}}
                        </td>

                        <td>

                            <a href="{{route('studentdetails',$value->id)}}" class="btn btn-success">view</a>
                        </td>
                    </tr>
                @endforeach

            @endif

            </tbody>
        </table>
            </div>
    </div>

@stop
