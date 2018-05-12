@extends('layouts.app')

@section('content')

@if (Route::has('login'))
    @auth
        @if (Session::has('mensaje'))
            @foreach (Session::get('mensaje') as $element)
                <p>{{ $element }}</p>
            @endforeach
        @endif

        @foreach ($pregunta as $valor)
            <h1>Pregunta {{ $valor->pre_id }}</h1>
            <p>{{ $valor->pre_content }}</p>
            @foreach ($respuesta as $res)
                @if ($res->res_pre_id == $valor->pre_id)
                    {{ $res->res_content }}<br>
                @endif
            @endforeach
            <form action="/admin/edit" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="editar" value="{{ $valor->pre_id }}">
                <input type="submit" value="modificar">
            </form>
            <form action="/admin/erase" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="borrar" value="{{ $valor->pre_id }}">
                <input type="submit" value="Borrar">
            </form>
        @endforeach
    @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    @endauth
@endif

@endsection