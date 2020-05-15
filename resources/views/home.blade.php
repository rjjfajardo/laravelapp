@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <br>
                <div class="panel panel-default">
                    &nbsp;&nbsp;<a href="/posts/create" class="btn btn-primary">Create Post</a>
                </div>
                    <br><br>
                </div>
                <br>
                @if(count($posts) > 0)
                <table class="table table-hover"> 
                    <tr>
                        <thead class="thead-dark">
                        <th>Title</th>
                        <th>Action</th>
                        <th></th>
                        </thead>
                    </tr>
                    @foreach ($posts as $post)
                    <tr>
                    <td><a href="/posts/{{$post->id}}">{{$post->title}}</a></td>
                        <td><a href="/posts/{{$post->id}}/edit" class="btn btn-success">Edit</a></td>
                        <th>
                            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'method'=> 'POST', 'class' => 'pull-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class'=> 'btn btn-danger'])}}
                             {!! Form::close()!!}
                        </th>
                    </tr>
                    @endforeach
                </table>
            @else
                <p>You have no posts</p>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
