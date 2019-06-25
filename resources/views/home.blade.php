@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/posts/create" class="btn btn-primary">Create Post</a><br>
                    <hr><h3>Your Blog Post</h3><hr>
                    @if (count($myposts) > 0)    
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th></th>
                            </tr>
                            @foreach ($myposts as $post)
                                <tr>
                                    <td><a href="/posts/{{$post->id}}">{{$post->title}}</a></td>
                                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a></td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>No Posts</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
