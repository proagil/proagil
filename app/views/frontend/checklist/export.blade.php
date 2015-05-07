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
			<h2 style="text-align:center;color:#42c2b8">Lista de Comprobación</h2> 
			<h4 style="text-align:center" >{{$info['title']}}</h2> 			
		</div>	

		<table style="width:100%">
		  <tr>
		    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">¿Se cumple?</td>
		    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Regla</td> 
		  </tr>
		  @foreach($items as $item)
		  <tr>

		    <td style="text-align:center;">

		    	@if($item['status']==1)
		    		<img  style="width:20px;" src="{{base_path('public/images/export-yes.png')}}"/>
		    	@else
		    		<img  style="width:20px;" src="{{base_path('public/images/export-no.png')}}"/>
		    	@endif

		    </td>
		    <td style="text-align:left;">{{$item['rule']}}: {{$item['description']}}</td> 
		  </tr>
		  @endforeach
		</table>

		<div style="text-align:center; background-color:#F6F6F6">
			Generado con: 
			<img style="text-align:center;color:#42c2b8" src="http://s11.postimg.org/duhv9zmv7/logo_sm.png">	
		</div>				

		
	</body>
</html>
