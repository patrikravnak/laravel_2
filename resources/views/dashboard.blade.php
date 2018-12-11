@extends('layouts.app')

@section('content')
<h1>Nadzorna plošča</h1>
<hr>
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="card">
                <div class="card-body">
                    <a href="/posts/create" class="btn btn-primary">Ustvari objavo</a>
                    <br>
                    <br />
                    <h3>Tvoje objave</h3>
                    @if(count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Naslov</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">Uredi</a></td>
                                    <td>
                                        {!!Form::open(['action' => ['PostController@destroy', $post->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!!Form::close()!!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <p>Nimaš še objav</p>
                    @endif
                </div>
        </div>
    </div>
@endsection
