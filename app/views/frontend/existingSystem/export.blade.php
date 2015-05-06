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

			table {
			    border-collapse: collapse;
			}

			table, th, td {
			   border: 1px solid black;
			}			

		</style>
	</head>

	<body>
		<div style="text-align:center; background-color:#F6F6F6">
			<h2 style="text-align:center;color:#42c2b8">Análisis de sistema existente</h2> 
			<h4 style="text-align:center" >{{$name}}</h2> 			
		</div>

			@if($interface!=NULL)
			  <div style="width:100%;text-align:center;">
			  	<img  style="width:500px;" src="{{base_path('public/uploads/'.$interface_image)}}"/>
			  </div>
		  @endif		

		<table style="width:100%">
		  <tr>
		    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Característica</td>
		    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Observación</td> 
		  </tr>
		  @foreach($elements as $element)
		  <tr>
		    <td style="text-align:left;">{{$element['topic_name']}}</td>
		    <td style="text-align:left;">{{$element['observation']}}</td> 
		  </tr>
		  @endforeach
		</table>

		<div style="text-align:center; background-color:#F6F6F6">
			Generado con: 
			<img style="text-align:center;color:#42c2b8" src="http://s11.postimg.org/duhv9zmv7/logo_sm.png">	
		</div>				

		
	</body>
</html>
