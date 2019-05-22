@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Update your Subject Information</h1>
@stop

@section('content')
    <div class="col-md-7 col-md-offset-2" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Update your Subject</h3>
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

            <form name="courseupdate" class="form-horizontal" action="{{ route('updatesubjectData') }}" method="post">
                @csrf
                <div class="box-body">

                    <div class="form-group">

                        <input type="hidden" value="{{$subjectupdate->id}}" name="id">
                        <label for="subject" class="col-sm-3 control-label">Subject Name</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject Name" value="{{$subjectupdate->subject}}">
                        </div>
                    </div>
                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right">Update</button>
                </div>
                    </div>
                <!-- /.box-footer -->
            </form>
        </div>

    </div>

@endsection