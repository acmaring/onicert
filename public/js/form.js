$(window).ready(function(){

	//Consulta para mostrar las competencias pertenecientes a un esquema en crear pregunta
	$('#esquema').change(function(){
		var token = $('input[name=_token]').val()
		//console.log(token)
		var valor = $('#esquema').val()
		var datos = { esquema : valor, _token : token}
		var url = $('#esquema').attr('data-url')
		$('#competencia').html('<option value=\"cargando\">cargando...</option>')
		$.post(url, datos, function(retorno){
			$('#competencia').html(retorno)
		})
	})

	//Consulta para mostrar las competencias pertenecientes a un esquema en mostrar pregunta
	$('#esquemaCreate').change(function(){
		var token = $('input[name=_token]').val()
		//console.log(token)
		var valor = $('#esquemaCreate').val()
		var datos = { esquema : valor, _token : token}
		var url = $('#esquema').attr('data-url')
		$('#competenciaCreate').html('<option value=\"cargando\">cargando...</option>')
		$.post(url, datos, function(retorno){
			$('#competenciaCreate').html(retorno)
		})
	})

	//Para tener seleccionado el dato que viene original
	// $('input[name=restrict]').attr(function(){

	// })
})