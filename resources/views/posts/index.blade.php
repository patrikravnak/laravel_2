@extends('layouts.app')

@section('content')

<h1>Objave</h1>
<hr />
@if (count($posts) > 0)
    @foreach ($posts as $post)
        <div class="card">
            <div class="row" style="padding: 10px 0 10px 10px;">
                <div class="col-md-2 col-sm-2">
                    <img style="width:100%;" src="/storage/cover_images/{{$post->cover_image}}">
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                    <small>Objavil {{$post->user->name}}, {{date('d.m.Y H:i', strtotime($post->created_at))}}</small>
                </div>
        </div>
    @endforeach
@else
    <p>Ni nobenih objav</p>
@endif
@endsection
