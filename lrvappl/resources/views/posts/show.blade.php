@extends('layouts.app')

@section('content')
<h1>{{$post->title}}</h1>
<a href="/posts" class="btn btn-default">Back</a>
<div>
    {{$post->body}}
</div>
<hr>
<small>Upload on {{$post->created_at}}</small>
<hr>
<a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
{{Form::open(['action'=>['PostsController@destroy',$post->id],'method'=>'POST','class'=>'float-right'])}}
    {{Form::hidden('_method','DELETE')}}
    {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
{{Form::close()}}
@endsection