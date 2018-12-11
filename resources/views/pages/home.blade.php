@extends('layouts.app')

@section('content')

<div class="jumbotron text-center">
    <h1>Dobrodošli na spletnih testih @auth{{auth()->user()->name}}@endauth!</h1>
    @guest
    <p>Za uporabo storitev se prijavite ali registrirajte!</p>
    <p><a class="btn btn-primary btn-lg" href="/login" role="button">Prijava</a> <a class="btn btn-success btn-lg" href="/register" role="button">Registracija</a></p>
    @endguest
</div>
@endsection
