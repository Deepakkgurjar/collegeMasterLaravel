@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Make Class Representative</h1>

@stop

@section('content')
    <div class="col-md-7 col-md-offset-2" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Assign a Sub Admin for a Class</h3>
            </div>

            @if($errors->count() > 0)
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">{{$error}}</p>
                @endforeach
            @endif
            @if(Session::has('message'))
                <div class="alert alert-success"> {{Session::get('message')}}</div>

            @endif

            <form name="student_detail" class="form-horizontal" action="{{route('makeSubAdmin')}}" method="post">
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
                        <label for="username" class="col-sm-3 control-label">Email</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Student Email Id">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Enter Password">
                        </div>
                    </div>

                </div>
                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right">Make Sub Admin</button>
                </div>
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
