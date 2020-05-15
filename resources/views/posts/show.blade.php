@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-warning">Go Back</a>
    <br><br>
    <h3>{{$post->title}}</h3>
    <img  style="width: 50%;" src="/storage/cover_images/{{$post->cover_img}}">
    <div>
        <p>{{$post->body}}</p>
    </div>
    <hr>
    <small>{{$post->created_at}} by {{$post->user->name}}</small>
    <hr>

   
    @if(!Auth::guest()) 
    <a href="/posts/{{$post->id}}/edit" class="btn btn-success ">Edit</a> 

    <br>
    <br>    
     {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method'=> 'POST', 'class' => 'pull-right'])!!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
     {!! Form::close()!!}
     @endif
@endsection