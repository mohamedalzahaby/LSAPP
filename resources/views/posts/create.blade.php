@extends('layouts.app')
@section('content')

<br>
<h3>Create Post</h3>
{!! Form::open(array('action' => 'PostsController@store','method' => 'POST' , 'enctype'=>'multipart/form-data')) !!}
<div class="form-group">
    {{ Form::label('mytitle', 'title') }}
    {{ Form::text('title', '' , ['class'=>"form-control", 'placeholder'=>"Title"]) }}
</div>
<div class="form-group">
    {{ Form::label('mybody', 'body') }}
    {{ Form::textarea('body' ,'', [ 'id' => 'article-ckeditor', 'class'=>"form-control", 'placeholder'=>"Body Text"])}}
</div>
<div class="form-group">
    {!! Form::file('cover_image')!!}
</div>
{{ Form::submit('Submit' ,['class' => 'btn btn-primary']) }}
{!! Form::close() !!}

@endsection
