@extends('adminlte::page')

@section('title', 'Dashboard')
<link rel="icon" href="{!! asset('images/collegemaster2.png') !!}"/>
@section('content_header')
    <h1>Watch Video</h1>

@stop

@section('content')


    @if(Session::has('message'))
        <div class="alert alert-success"> {{Session::get('message')}}</div>

    @endif

    @if(Session::has('error'))
        <div class="alert alert-danger"> {{Session::get('error')}}</div>

    @endif

    <div>
        <video width="800"  style="margin-left: 100px; margin-top: 20px; border-radius: 40px;" controls autoplay="autoplay" >
            <source src="{{asset($video->video)}}" type="video/mp4">

            Your browser does not support HTML5 video.
        </video>

        <div style="margin-left: 100px;">

            <hr>
            <h3>Title : {{$video->title}}
                <br>
                Description :{{$video->video_description}}
                <br>
                Course: {{$video->course->course}}
                <br>
                Taught By : {{$video->course->taughtby}}
                <br>
                Time :{{$video->created_at}}

            </h3>

        </div>

    </div>
@stop

