<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title> REGISTRAR USUARIO </title>
		<style>
			/* -------------------------------------
				GLOBAL
			------------------------------------- */
			* {
			  font-family: "sans-serif", sans-serif;
			  font-size: 14px;
			}

			img {
				display: block;
				width: 10%;
			}

			body {
			  width: 100%;
			  height: auto;

			}

		</style>
	</head>

	<body>
		<div style="text-align:center; background-color:#F6F6F6">
			<h2 style="text-align:center;color:#42c2b8" >Resultados de Sondeo</h2> 
			<h4 style="text-align:center" >{{$title}}</h2> 			
		</div>

		@foreach($responses as $index => $response)
		<div class="response-data">
			<p style="font-weight: bold;"> Pregunta {{$index + 1}}: {{$response['question']}} </p>
			@if($response['form_element'] == 1 || $response['form_element'] == 2)
				@foreach($response['results'] as $result)
				<p> {{$result}} <p>
				@endforeach
			@else
				@foreach($response['results'] as $result)
					<p> Opci&oacute;n {{$result['name']}} - {{$result['result_count']}} respuesta(s) ({{$result['percent']}}%)  <p>
				@endforeach	
			@endif					
		</div>
		@endforeach

		<div style="text-align:center; background-color:#F6F6F6">
			Generado con: 
			<img style="text-align:center;color:#42c2b8" src="http://s11.postimg.org/duhv9zmv7/logo_sm.png">	
		</div>

		
	</body>
</html>
