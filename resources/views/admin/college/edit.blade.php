@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Edit Colleges</h1>
@stop

@section('content')
    <div class="col-md-6 col-md-offset-3" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">College Registration Form</h3>
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

            <form name="collegeform" class="form-horizontal" action="{{ route('updatecollegeData') }}" method="post">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <input type="hidden" value="{{$collegeData->id}}" name="id">
                        <label for="collegename" class="col-sm-3 control-label">College Name</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="collegename" name="college" placeholder="Enter college Name" value="{{$collegeData->college}}">
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