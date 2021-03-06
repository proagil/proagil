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
			<h2 style="text-align:center;color:#42c2b8">Evaluación Heurística</h2> 
			<h4 style="text-align:center" >{{$name}}</h2> 			
		</div>

		<table style="width:100%">
		  <tr>
		    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Problema</td>
		    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Heurísitca</td> 
		    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Valoración</td>
		    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Solución</td>
		  </tr>
		  @foreach($elements as $element)
		  <tr>
		    <td style="text-align:left;">{{$element['problem']}}</td>
		    <td style="text-align:left;">{{$element['heuristic_name']}}</td> 
		    <td style="text-align:left;">{{$element['valoration_name']}}</td>
		    <td style="text-align:left;">{{$element['solution']}}</td>
		  </tr>
		  @endforeach
		</table>

		<div style="text-align:center; background-color:#F6F6F6">
			Generado con: PROAGIL
		</div>				

		
	</body>
</html>
