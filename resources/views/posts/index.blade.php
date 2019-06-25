@extends('layouts.app')
@section('content')
<h3>posts</h3>
@if (count($posts) > 0)
@foreach ($posts as $post)
    <div class="well">
        <div class="row">
            <div class="col-md-4 col-sm-4">
            <img src="/storage//cover_images/{{$post->cover_Image}}" style="width:100%" alt="{{$post->cover_Image}}">
            </div>
            <div class="col-md-8 col-sm-8">
                <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                <small>written on {{$post->created_at}}</small>
            </div>
        </div>
    </div>
    <hr>
    @endforeach
    {{-- {{$posts->links()}} --}}
@else
    <p>no Posts</p>
@endif
@endsection
