@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Add More Courses</h1>
@stop

@section('content')
    <div class="col-md-7 col-md-offset-2" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Select College, Class and Course</h3>
            </div>

            @if($errors->count() > 0)
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{$error}}</p>
                @endforeach
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success"> {{Session::get('message')}}</div>

            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger"> {{Session::get('error')}}</div>

            @endif
            <form name="addclassform"  method="post" action="{{route("registercourse")}}" class="form-horizontal">
                @csrf
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
                                <option value ="">--select Subject Name--</option>




                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="coursename" class="col-sm-3 control-label">Course Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="course" name="course" placeholder="Enter Course Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="coursedescription" class="col-sm-3 control-label">Course Description</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="course_description" name="course_description" placeholder="Enter Course Description">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="taughtby" class="col-sm-3 control-label">Taught By</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="taughtby" name="taughtby" placeholder="Enter Professor Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="courseduration" class="col-sm-3 control-label">Course Duration</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="course_duration" name="course_duration" placeholder="Enter Duration(Time in Month) of Course">
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="prerequisites" class="col-sm-3 control-label">Pre-Requisites</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="prerequisites" name="prerequisites" placeholder="Enter prerequisites(Basic Knowledge for this course )">
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right">Add course</button>
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
                    url:baseUrl+"/course/class-fetch/"+id,
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
                    url:baseUrl+"/course/subject-fetch/"+id,
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
@stop

@endsection


