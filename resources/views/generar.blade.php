@extends('layouts.app')

@section('content')
	@if (Route::has('login'))
		@auth
			@foreach ($esquema as $esq)
			<p>{{ $esq->esq_name }}</p>
			@endforeach
				@php
					$count=0;
				@endphp
				@foreach ($competencia as $com)
					<p>{{ $com->com_name }}</p>
					@foreach ($pregunta as $pre)
						@if ($pre->pre_com_id == $com->com_id)
							@php
								$opciones = ['a. ','b. ','c. ','d. '];
								$countOpciones = 0;
							@endphp
						    {{-- <h1>Pregunta {{ ++$count }}</h1> --}}
						    <p>{{ ++$count.'. '.$pre->pre_content }}:</p>
						    @foreach ($respuesta as $res)
						    	@if ($res->res_pre_id == $pre->pre_id)
						    		{{ $opciones[$countOpciones++].$res->res_content }}<br>
						    	@endif
						    @endforeach
						    <br>
						@endif
					@endforeach
				@endforeach
		@else
			<a href="{{ route('login') }}">Login</a>
           	<a href="{{ route('register') }}">Register</a>
		@endauth
	@endif
    <br>
	{{-- {{ $restriccion }} --}}
@endsection