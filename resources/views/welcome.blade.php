@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>

                     <div class="content">

                        <div class="row">
                            <a href="/admin">admin</a>
                        </div>

                        <div class="row">
                            {{-- <a href="/generate">Generar</a> --}}
                            <form action="/generate" method="post">
                                {{ csrf_field() }}
                                <label for="esq">Esquema: </label>
                                <select name="esq">
                                    @foreach ($esquema as $esq)
                                        <option value="{{ $esq->esq_id }}">{{ $esq->esq_name }}</option>
                                    @endforeach
                                </select>
                                <input type="submit" value="Generar">
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        @endif
    </div>
@endsection
