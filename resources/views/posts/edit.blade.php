@extends('layouts.app')

@section('content')
    <a href="/posts/{{$post->id}}" class="btn btn-warning">Back</a>
    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST']) !!}
    <br>    
    <div class="form-group">
            {{ Form:: label('title', 'Title')}}
            {{ Form:: text('title',$post->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
        </div>
        <div class="form-group">
            {{ Form:: label('body', 'Body')}}
            {{ Form:: textarea('body', $post->body, ['class' => 'form-control', 'placeholder' => 'Body'])}}
        </div>
        <div class="form-group">
            {{ Form::file('cover_img')}}
         </div>
        {{ Form::hidden('_method', 'PUT')}}
    {{ Form::submit('Save Changes', ['class'=> 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection