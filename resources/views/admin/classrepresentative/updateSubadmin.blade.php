@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Update Admin Information</h1>
@stop

@section('content')
    <div class="col-md-6 col-md-offset-3" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Modify Information</h3>
            </div>

            @if($errors->count() > 0)
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{$error}}</p>
                @endforeach
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success"> {{Session::get('message')}}</div>

        @endif
        <!-- /.box-header -->
            <!-- form start -->

            <form name="collegeform" class="form-horizontal" action="{{route('updatesubadminData')}}" method="post">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <input type="hidden" value="{{$updateSubAdmin->id}}" name="id">
                        <label for="collegename" class="col-sm-3 control-label">Email-id</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Id" value="{{$updateSubAdmin->email}}">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="collegename" class="col-sm-3 control-label">password</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Enter New Password " value="">
                        </div>
                    </div>
                </div>

                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right">Update</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>

    </div>

@endsection