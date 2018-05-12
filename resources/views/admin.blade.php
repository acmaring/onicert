{{-- <!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Administrador</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body> --}}

@extends('layouts.app')
@section('content')
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth

                        @if (Session::has('mensaje'))
                            @foreach (Session::get('mensaje') as $element)
                                <div>
                                    <p>{{ $element }}</p>
                                </div>
                            @endforeach
                        @endif

                        <a href="{{ url('/home') }}">Home</a>
                        
                        {{-- Formulario para agregar preguntas y respuestas --}}
                        <div class="content">
                           <div class="row">
                               <form action="/admin/create" method="post">
                                    {{ csrf_field() }}
                                    <label for="pregunta">Pregunta: </label>
                                    <input type="text" name="pregunta">
                                    <br>
                                    <label for="esquema">Esquema :</label>
                                    <select id="esquemaCreate" name="esquema" data-url="{{  url('/admin/validate') }}">
                                        @foreach ($esquema as $element)
                                            <option value="{{ $element->esq_id }}">{{ $element->esq_name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Competencia: </label>
                                    <select id="competenciaCreate" name="competencia">
                                        @foreach ($competencia as $element)
                                            <option value="{{ $element->com_id }}">{{ $element->com_name }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input type="hidden" name="competencia" value="allie.hackett"> --}}
                                    {{-- <input type="hidden" name="id" value=3> --}}
                                    <br>
                                    <label for=""> ninguno</label>
                                    <input type="radio" name="restrict" value=0 required>
                                    <label for=""> Examen 1</label>
                                    <input type="radio" name="restrict" value=1>
                                    <label for=""> Examen 2</label>
                                    <input type="radio" name="restrict" value=2>
                                    <br>
                                    <div>
                                        <label for="">Respuestas: </label>
                                        <label for="respuestaA">a: </label>
                                        <input type="text" name="respuestaA">
                                        <input type="radio" name="correcta" value="a" required>
                                        <label for="respuestaB">b: </label>
                                        <input type="text" name="respuestaB">
                                        <input type="radio" name="correcta" value="b">
                                        <label for="respuestaC">c: </label>
                                        <input type="text" name="respuestaC">
                                        <input type="radio" name="correcta" value="c">
                                        <label for="respuestaD">d: </label>
                                        <input type="text" name="respuestaD">
                                        <input type="radio" name="correcta" value="d">
                                    </div>
                                    @if ($errors->any())
                                        @foreach ($errors->get('pregunta') as $error)
                                            {{ $error }}
                                        @endforeach
                                    @endif

                                    <input type="submit" value="Guardar">
                                    <input type="button" name="cancelar" value="cancelar" onclick="/">
                                </form>
                           </div> 
                           <br>
                           <br>
                           <div>
                                <form action="/admin/show" method="get">
                                    <label for="esquema">Esquema :</label>
                                    <select id="esquema" name="esquema" data-url="{{  url('/admin/validate') }}">
                                        <option selected disabled>selecionar</option>
                                        @foreach ($esquema as $element)
                                            <option value="{{ $element->esq_id }}">{{ $element->esq_name }}</option>
                                        @endforeach
                                    </select>
                                    <label>Competencia: </label>
                                    <select id="competencia" name="competencia">
                                        {{-- @foreach ($competencia as $element)
                                            <option value="{{ $element->com_id }}">{{ $element->com_name }}</option>
                                        @endforeach --}}
                                    </select>
                                    <input type="submit" value="Mostrar">
                                    <input type="button" name="cancelar" value="cancelar" onclick="location.href='/'">
                                </form>
                               {{-- <a href="{{ route('showComp', array('pre_id' => 'allie.hackett')) }}">Mostrar preguntas</a> --}}
                           </div>
                        </div>
                    </div>
                    {{-- JQery --}}
                    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
                    <script type="text/javascript" src="{{ asset('js/form.js') }}"></script>

                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            

            
@endsection
    {{-- </body>
</html> --}}
