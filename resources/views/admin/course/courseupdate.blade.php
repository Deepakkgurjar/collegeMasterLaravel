@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Update your Course Information</h1>
@stop

@section('content')
    <div class="col-md-7 col-md-offset-2" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Update your Course</h3>
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

            <form name="courseupdate" class="form-horizontal" action="{{ route('updatecourseData') }}" method="post">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <input type="hidden" value="{{$courseupdate->id}}" name="id">
                        <label for="courseName" class="col-sm-3 control-label">Course Name</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="coursename" name="course" placeholder="Enter Course Name" value="{{$courseupdate->course}}">
                        </div>

                    </div>
                    <div class="form-group">

                        <label for="courseDescription" class="col-sm-3 control-label">Course Description</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="courseDescription" name="course_description" placeholder="Enter Course Description" value="{{$courseupdate->course_description}}">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="taught_by" class="col-sm-3 control-label">Taught By</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="taughtby" name="taughtby" placeholder="Enter Faculty Name" value="{{$courseupdate->taughtby}}">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="course_duration" class="col-sm-3 control-label">Course Duration</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="course_duration" name="course_duration" placeholder="Enter Estimate Duration" value="{{$courseupdate->course_duration}}">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="prerequisites" class="col-sm-3 control-label">Pre-Requisites</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="prerequisites" name="prerequisites" placeholder="Enter prerequisites for course" value="{{$courseupdate->prerequisites}}">
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