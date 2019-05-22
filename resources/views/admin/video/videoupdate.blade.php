@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Update your Video Information</h1>
@stop

@section('content')
    <div class="col-md-7 col-md-offset-2" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Update your Video</h3>
            </div>

            @if($errors->count() > 0)
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{$error}}</p>
                @endforeach
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success"> {{Session::get('message')}}</div>

        @endif

            <form name="videoupdate" class="form-horizontal", enctype="multipart/form-data" action="{{ route('updatevideoData') }}" method="post">
                {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group">
                        <input type="hidden" value="{{$videoupdate->id}}" name="id">
                        <label for="video" class="col-sm-3 control-label">Video Title</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Video Title" value="{{$videoupdate->title}}">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="video_description" class="col-sm-3 control-label">Video Description</label>

                        <div class="col-sm-6">
                            <textarea class="form-control" id="video_description" name="video_description" placeholder="Write Description" value="{{$videoupdate->video_description}}">{{$videoupdate->video_description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="video_thumb" class="col-sm-3 control-label">Add Video Thumb</label>

                        <div class="col-sm-6">
                            <input type="file" class="form-control" id="video_thumb" name="video_thumb" placeholder="Choose Your Video Thumb nail " value="">
                        </div>
                    </div>
                    <div class="form-group">

                        <label for="video_upload" class="col-sm-3 control-label">Video Upload</label>

                        <div class="col-sm-6">
                            <input type="file" class="form-control" id="video" name="video" placeholder="Choose Your Video " value="">
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