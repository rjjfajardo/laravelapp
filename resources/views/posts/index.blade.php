@extends('layouts.app')


@section('content')

        <h1>POSTS</h1>  <a href="/posts/create" class="btn btn-success">Create Post</a>
        @if(count($posts) > 0 )
                @foreach ($posts as $post)
                <br><br>
                   <div class="jumbotron" style="background: grey; border-radius: 2em;">
                        <div class="row">
                                <div class="col-md-4 col-sm-4">
                                <img  style="width: 310px; height: 300px;" src="/storage/cover_images/{{$post->cover_img}}">
                                </div>
                                <div class="col-md-8" style="background: white; padding-top: 10px;">
                                        <h2><a href="/posts/{{$post->id}}">{{$post->title}}</a></h2>
                                        <p>Written on {{$post->created_at}} by {{$post->user->name}}</p>
                                        <br>
                                        <p>{{$post->body}}</p>
                                </div>
                        </div>
                   </div>
                @endforeach
                <div class="pagination justify-content-center">
                {{$posts->links()}}      
                </div>
        @else
         <p>no post found</p>   
      @endif
@endsection

