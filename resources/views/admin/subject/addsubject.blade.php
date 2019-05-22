@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Add More Subjects</h1>
@stop

@section('content')
    <div class="col-md-7 col-md-offset-2" >

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Select College and Class</h3>
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
            <form name="addclassform"  method="post" action="{{route("registersubject")}}" class="form-horizontal">
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
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject Name">
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-info pull-right">Add Subject</button>
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
                   url:baseUrl+"/subject/class-fetch/"+id,
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
    @stop
@endsection


