@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Add Videos Here</h1>

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

                <form name="videoupload" class="form-horizontal" enctype="multipart/form-data" action="{{ route('uploadvideo') }}" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="collegename" class="col-sm-3 control-label">College Name</label>

                            <div class="col-sm-8">
                                <select id="college" name="college_id" class="form-control">
                                    <option value="">--select College Name--</option>
                                    @if(count($colleges)>0)
                                        @foreach($colleges as $key => $value)

                                            <option value="{{$value->id}}">{{$value->college}}</option>
                                        @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="classname" class="col-sm-3 control-label">Class Name</label>
                            <div class="col-sm-8">
                                <select id="class" name="class_id" class="form-control">
                                    <option value="">--select Class Name--</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="classname" class="col-sm-3 control-label">Subject Name</label>
                            <div class="col-sm-8">
                                <select id="subject" name="subject_id" class="form-control">
                                    <option value="">--select Subject Name--</option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="coursename" class="col-sm-3 control-label">Course Name</label>
                            <div class="col-sm-8">
                                <select id="course" name="course_id" class="form-control">
                                    <option value="">--select Course Name--</option>


                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="videotitle" class="col-sm-3 control-label">Video Title</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Video Title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="videodescription" class="col-sm-3 control-label">Video Description</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="video_description" name="video_description" placeholder="Enter Full Video Description">
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="video_thumb" class="col-sm-3 control-label">Add Video Thumb</label>

                            <div class="col-sm-6">
                                <input type="file" class="form-control" id="video_thumb" name="video_thumb" placeholder="Choose Your Video Thumb Nail " value="">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="video_upload" class="col-sm-3 control-label">Video Upload</label>

                            <div class="col-sm-6">
                                <input type="file" class="form-control" id="video" name="video" placeholder="Choose Your Video " value="">
                            </div>
                        </div>
                        <div class="box-footer">

                            <button type="submit" class="btn btn-info pull-right">Upload Video</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
        </div>

    </div>
@section('js')
    <script>
        $(document).ready(function(){
            $('#college').on('change', function(){
                var id =  $(this).val();
                var baseUrl = "{{URL::to('/')}}";

                $.ajax({
                    url:baseUrl+"/video/class-fetch/"+id,
                    method:"GET",
                    beforeSend: function(){


                    },
                    success:function(data) {
                        $('#class').html(data);
                    },
                    error:function (err) {
                        var error = err.responseJSON;
                        alert(error.message);
                    }
                });

            });
        });

    </script>
    <script>
        $(document).ready(function(){
            $('#class').on('change', function(){
                var id =  $(this).val();
                var baseUrl = "{{URL::to('/')}}";

                $.ajax({
                    url:baseUrl+"/video/subject-fetch/"+id,
                    method:"GET",
                    beforeSend: function(){

                    },
                    success:function(data) {
                        $('#subject').html(data);
                    },
                    error:function (err) {
                        var error = err.responseJSON;
                        alert(error.message);
                    }
                });

            });
        });

    </script>
    <script>
        $(document).ready(function(){
            $('#subject').on('change', function(){
                var id =  $(this).val();
                var baseUrl = "{{URL::to('/')}}";

                $.ajax({
                    url:baseUrl+"/video/course-fetch/"+id,
                    method:"GET",
                    beforeSend: function(){

                    },
                    success:function(data) {
                        $('#course').html(data);
                    },
                    error:function (err) {
                        var error = err.responseJSON;
                        alert(error.message);
                    }
                });

            });
        });

    </script>
@stop

@endsection
