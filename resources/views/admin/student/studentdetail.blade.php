@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
<style>

    .bk-btn {
        height: 52px;
        width: 52px;
        background-color: #00a7d0;
        border-radius: 50%;
    }
    .bk-btn:hover {
        background-color: #008000;
        color: black;
    }
    .bk-btn-triangle {
        position: relative;
        top: 13px;
        left: 10.4px;
        width: 0;
        height: 0;
        border-top: 13px solid transparent;
        border-bottom: 13px solid transparent;
        border-right: 13px solid white;
    }
    .bk-btn-bar {
        position: relative;
        background-color: #f1f1f1;
        height: 5.8px;
        width: 13px;
        top: -3.64px;
        left: 22.88px;
    }

</style>
@section('content_header')

   {{--<div class="bk-btn"><a href="javascript:history.back()" ><div class="bk-btn-triangle"></div><div class="bk-btn-bar"></div></a></div>--}}

    <h1>Student Details</h1>

@stop

@section('content')
    <div class="col-md-7 col-md-offset-2" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Personal Details</h3>
            </div>

            @if($errors->count() > 0)
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{$error}}</p>
                @endforeach
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success"> {{Session::get('message')}}</div>

            @endif


                <div class="box-body">
                    <div class="box-body no-padding">
                        <ul class="" style="list-style-type: none">
                            <li>
                                <img style="height: 150px; width:200px;" src="{{asset($personaldetail->id_card)}}" alt="Student Image">
                            </li>

                        </ul>
                        <!-- /.users-list -->
                    </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody style="font-size: large;">
                                <tr>
                                    <td>Name </td>
                                    <td>
                                        {{$personaldetail->name}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>College Name </td>
                                    <td>
                                        {{$personaldetail->college->college}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Class Name </td>
                                    <td>
                                        {{$personaldetail->classes->class}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Year </td>
                                    <td>
                                        {{$personaldetail->year}}
                                    </td>

                                </tr>
                                <tr>
                                    <td>Email </td>
                                    <td>
                                        {{$personaldetail->email}}
                                    </td>

                                </tr>
                                </tbody></table>
                        </div>

                </div>
                <div class="box-footer">

                    @if($personaldetail->verify=='n')
                        <a href="{{route('approvel',$personaldetail->id)}}" class="btn btn-info pull-right">Give Approvel</a>
                    @else
                        <a href="{{route('approvel',$personaldetail->id)}}" class="btn btn-danger pull-right">Disapprove</a>
                    @endif
                </div>
                <!-- /.box-footer -->

        </div>

    </div>
@endsection
