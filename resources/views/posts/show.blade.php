@extends('layouts.app')

@section('content')

    <h1>{{$post->title}}</h1>
    <small>Objavil {{$post->user->name}}, {{date('d.m.Y H:i', strtotime($post->created_at))}}</small>
    <hr />
    <img style="height:400px;" src="/storage/cover_images/{{$post->cover_image}}">

    <div class="card-body">{!! nl2br(e($post->body)) !!}</div>
    <br>

    @auth
    @if (Auth::user()->id == $post->user_id)
    <a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">Edit</a>

    {!!Form::open(['action' => ['PostController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {{Form::hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
    @endif
    @endauth

    <h3>Comments</h3>
    @if (Auth::check())
    {{ Form::open(['route' => ['comments.store'], 'method' => 'POST']) }}
    <p>{{ Form::textarea('body', old('body'))}}</p>
    {{ Form::hidden('post_id', $post->id) }}
    <p>{{ Form::submit('Send') }}</p>
    {{ Form::close() }}
    @endif
    @forelse ($post->comments as $comment)
    <h5>{{ $comment->user->name }} {{date('d.m.Y H:i', strtotime($comment->created_at))}}</h5>
    <p>{!! nl2br(e($comment->body)) !!}</p>
    <hr>
    @empty
    <p>This post has no comments</p>
    @endforelse

@endsection
