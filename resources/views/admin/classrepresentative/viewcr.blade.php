@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Class Representative List</h1>
@stop

@section('content')
    <div>
        @if(Session::has('message'))
            <div class="alert alert-success"> {{Session::get('message')}}</div>

        @endif

        @if(Session::has('error'))
            <div class="alert alert-danger"> {{Session::get('error')}}</div>

        @endif


        {{--<div class="row">--}}
        {{--<div class="col-md-12">--}}
        {{--<div class="form-group">--}}
        {{--<label class="col-sm-12 col-sm-offset-8 control-label">Approved By : </label>--}}

        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
            <div class="table-responsive">
                <table name="subAdmin_list" id="myTable" class="table">
            <thead>
            <tr >
                <th>
                    S.no
                </th>
                <th>
                    College
                </th>
                <th>
                    Class
                </th>
                <th>
                    Email Id
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
            </tr>
            </thead>
            <tbody>
            @if(count($subAdminList)>0)
                @foreach($subAdminList as $key => $value)

                    <tr>
                        <td>
                            {{$loop->index+1}}
                        </td>
                        <td>
                            @if(!empty($value->college))
                                {{$value->college->college}}
                            @else
                                 --
                            @endif
                        </td>
                        <td>
                            @if(!empty($value->classes))
                                {{$value->classes->class}}
                            @else
                                --
                            @endif
                        </td>
                        <td>
                            {{$value->email}}
                        </td>

                        <td>
                            {{$value->created_at}}
                        </td>
                        <td>
                            {{$value->updated_at}}
                        </td>

                        <td>
                            <a href="{{route('deleteSubAdmin',$value->id)}}" class="btn btn-danger"onclick="return confirm('You Want to Delete This Admin. ');">Delete</a>&nbsp;<br><br>&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="{{route('updateSubAdmin',$value->id)}}" class="btn btn-success">Update</a>
                        </td>

                    </tr>
                @endforeach
            @endif

            </tbody>

        </table>
            </div>
    </div>

@stop
