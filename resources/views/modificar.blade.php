@extends('layouts.app')

@section('content')

@if (Route::has('login'))
    @auth
        @foreach ($pregunta as $pre)
        {{-- <form>
            {{ csrf_field() }}
            <h1>Pregunta {{ $pre->pre_id }}</h1>
            <label for="content"></label>
            <input type="text" name="content" value="{{ $pre->pre_content }}">

        </form> --}}
            <form action="/admin/save" method="post">
                            {{ csrf_field() }}
                            <h1>Pregunta {{ $pre->pre_id }}</h1>
                            <label for="pregunta">Pregunta: </label>
                            {{-- <input type="text" name="pregunta" placeholder="{{ $pre->pre_content }}"> --}}
                            <input type="hidden" name="id" value="{{ $pre->pre_id }}">
                            <input type="text" name="pregunta" value="{{ $pre->pre_content }}">
                            <br>
                            <label for="esquema">Esquema :</label>
                            <select id="esquema" name="esquema" data-url="{{  url('/admin/validate') }}">
                                <option selected disabled>seleccionar</option>
                                @foreach ($esquema as $esq)
                                    <option value="{{ $esq->esq_id }}">{{ $esq->esq_name }}</option>
                                @endforeach
                            </select>
                            <p>cambiar competencia 
                                @foreach ($competencia as $com)
                                    @if ($pre->pre_com_id == $com->com_id)
                                        {{ $com->com_name }}
                                    @endif
                                @endforeach
                                a 
                            </p>
                            <label>Competencia: </label>
                            <select id="competencia" name="competencia">
                                @foreach ($competencia as $com)
                                    <option value="{{ $com->com_id }}">{{ $com->com_name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <p>cambiar restriccion
                                @switch($pre->pre_restrict)
                                    @case(0)
                                        ninguno
                                        @break
                                    @case(1)
                                        Examen 1
                                        @break
                                    @case(2)
                                        Examen 2
                                        @break
                                @endswitch
                                a
                            </p>
                            @if ($pre->pre_restrict == 0)
                                <label for="restrict"> ninguno</label>
                                <input type="radio" name="restrict" value=0 checked>
                                <label for="restrict"> Examen 1</label>
                                <input type="radio" name="restrict" value=1>
                                <label for="restrict"> Examen 2</label>
                                <input type="radio" name="restrict" value=2>
                            @endif
                            
                            @if ($pre->pre_restrict == 1)
                                <label for="restrict"> ninguno</label>
                                <input type="radio" name="restrict" value=0>
                                <label for="restrict"> Examen 1</label>
                                <input type="radio" name="restrict" value=1 checked>
                                <label for="restrict"> Examen 2</label>
                                <input type="radio" name="restrict" value=2>
                            @endif

                            @if ($pre->pre_restrict == 2)
                                <label for="restrict"> ninguno</label>
                                <input type="radio" name="restrict" value=0>
                                <label for="restrict"> Examen 1</label>
                                <input type="radio" name="restrict" value=1>
                                <label for="restrict"> Examen 2</label>
                                <input type="radio" name="restrict" value=2 checked>
                            @endif

                            <br>
                            <div>
                                @if ($respuesta[0]->res_correct == 1)
                                    {{ "Actual respuesta correcta A" }}

                                    <label for="">Respuestas: </label>
                                    <label for="respuestaA">a: </label>
                                    <input type="text" name="respuestaA" value={{ $respuesta[0]->res_content }}>
                                    <input type="hidden" name="res_idA" value="{{ $respuesta[0]->res_id }}">
                                    <input type="radio" name="correcta" value="a" checked>
                                    <label for="respuestaB">b: </label>
                                    <input type="text" name="respuestaB" value={{ $respuesta[1]->res_content }}>
                                    <input type="hidden" name="res_idB" value="{{ $respuesta[1]->res_id }}">
                                    <input type="radio" name="correcta" value="b">
                                    <label for="respuestaC">c: </label>
                                    <input type="text" name="respuestaC" value={{ $respuesta[2]->res_content }}>
                                    <input type="hidden" name="res_idC" value="{{ $respuesta[2]->res_id }}">
                                    <input type="radio" name="correcta" value="c">
                                    <label for="respuestaD">d: </label>
                                    <input type="text" name="respuestaD" value={{ $respuesta[3]->res_content }}>
                                    <input type="hidden" name="res_idD" value="{{ $respuesta[3]->res_id }}">
                                    <input type="radio" name="correcta" value="d">
                                @endif
                                @if ($respuesta[1]->res_correct == 1)
                                    {{ "Actual respuesta correcta B" }}

                                    <label for="">Respuestas: </label>
                                    <label for="respuestaA">a: </label>
                                    <input type="text" name="respuestaA" value={{ $respuesta[0]->res_content }}>
                                    <input type="hidden" name="res_idA" value="{{ $respuesta[0]->res_id }}">
                                    <input type="radio" name="correcta" value="a">
                                    <label for="respuestaB">b: </label>
                                    <input type="text" name="respuestaB" value={{ $respuesta[1]->res_content }}>
                                    <input type="hidden" name="res_idB" value="{{ $respuesta[1]->res_id }}">
                                    <input type="radio" name="correcta" value="b" checked>
                                    <label for="respuestaC">c: </label>
                                    <input type="text" name="respuestaC" value={{ $respuesta[2]->res_content }}>
                                    <input type="hidden" name="res_idC" value="{{ $respuesta[2]->res_id }}">
                                    <input type="radio" name="correcta" value="c">
                                    <label for="respuestaD">d: </label>
                                    <input type="text" name="respuestaD" value={{ $respuesta[3]->res_content }}>
                                    <input type="hidden" name="res_idD" value="{{ $respuesta[3]->res_id }}">
                                    <input type="radio" name="correcta" value="d">
                                @endif
                                @if ($respuesta[2]->res_correct == 1)
                                    {{ "Actual respuesta correcta C" }}

                                    <label for="">Respuestas: </label>
                                    <label for="respuestaA">a: </label>
                                    <input type="text" name="respuestaA" value={{ $respuesta[0]->res_content }}>
                                    <input type="hidden" name="res_idA" value="{{ $respuesta[0]->res_id }}">
                                    <input type="radio" name="correcta" value="a">
                                    <label for="respuestaB">b: </label>
                                    <input type="text" name="respuestaB" value={{ $respuesta[1]->res_content }}>
                                    <input type="hidden" name="res_idB" value="{{ $respuesta[1]->res_id }}">
                                    <input type="radio" name="correcta" value="b">
                                    <label for="respuestaC">c: </label>
                                    <input type="text" name="respuestaC" value={{ $respuesta[2]->res_content }}>
                                    <input type="hidden" name="res_idC" value="{{ $respuesta[2]->res_id }}">
                                    <input type="radio" name="correcta" value="c" checked>
                                    <label for="respuestaD">d: </label>
                                    <input type="text" name="respuestaD" value={{ $respuesta[3]->res_content }}>
                                    <input type="hidden" name="res_idD" value="{{ $respuesta[3]->res_id }}">
                                    <input type="radio" name="correcta" value="d">
                                @endif
                                @if ($respuesta[3]->res_correct == 1)
                                    {{ "Actual respuesta correcta D" }}

                                    <label for="">Respuestas: </label>
                                    <label for="respuestaA">a: </label>
                                    <input type="text" name="respuestaA" value={{ $respuesta[0]->res_content }}>
                                    <input type="hidden" name="res_idA" value="{{ $respuesta[0]->res_id }}">
                                    <input type="radio" name="correcta" value="a">
                                    <label for="respuestaB">b: </label>
                                    <input type="text" name="respuestaB" value={{ $respuesta[1]->res_content }}>
                                    <input type="hidden" name="res_idB" value="{{ $respuesta[1]->res_id }}">
                                    <input type="radio" name="correcta" value="b">
                                    <label for="respuestaC">c: </label>
                                    <input type="text" name="respuestaC" value={{ $respuesta[2]->res_content }}>
                                    <input type="hidden" name="res_idC" value="{{ $respuesta[2]->res_id }}">
                                    <input type="radio" name="correcta" value="c">
                                    <label for="respuestaD">d: </label>
                                    <input type="text" name="respuestaD" value={{ $respuesta[3]->res_content }}>
                                    <input type="hidden" name="res_idD" value="{{ $respuesta[3]->res_id }}">
                                    <input type="radio" name="correcta" value="d" checked>
                                @endif
                                
                            </div>
                            @if ($errors->any())
                                @foreach ($errors->get('pregunta') as $error)
                                    {{ $error }}
                                @endforeach
                            @endif

                            <input type="submit" value="Guardar cambios">
                            <input type="button" name="cancelar" value="cancelar" onclick="location.href='/'">

                            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                            <script type="text/javascript" src="{{ asset('js/form.js') }}"></script>
    @endforeach
    @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    @endauth
@endif
@endsection