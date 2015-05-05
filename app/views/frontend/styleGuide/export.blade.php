<!DOCTYPE>
<html>
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

			body {
			  width: 100%;
			  height: auto;

			}	

			.colors-content,
			.color-bg-style-guide,
			.a-class{
			 	width: 100%;
			 	height: auto;
			 	float: left;
			 	overflow: hidden;
			}

			img {
				display: block;
			}

			.color-bg-style-guide {
				float: left; 
				width: 70px;
				height: 70px; 
				margin: 2px;
				border: solid 5px rgb(227, 223, 236);
			}

			.detail-color {
				width: 80px; 
				height: auto;
			 	float: left;
			 	overflow: hidden;
			}

			.color-hexa {
				margin: 10px;
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
			<h2 style="text-align:center;color:#42c2b8">Guía de estilos</h2> 
			<h4 style="text-align:center">{{$name}}</h2> 			
		</div>

		<table style="width:100%">
			@if($interface !='')
			  <tr>
			    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Interfaz de usuario</td>
			    <td style="text-align:center"> 
			    	<img  style="width:500px;" src="{{base_path('public/uploads/'.$interface_image)}}"/>
			    </td> 
			  </tr>
			 @endif
			@if($logo !='')
			  <tr>
			    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Logo</td>
			    <td style="text-align:center"> 
			    	<img  style="width:200px;" src="{{base_path('public/uploads/'.$logo_image)}}"/>
			    </td> 
			  </tr>
			 @endif
			  <tr>
			    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Colores primarios</td>
			    <td>
				    <div class="colors-content">
				    @foreach($colors as $color)
						@if($color['type'] == 1)
							<div class="detail-color">
								<div class="color-bg-style-guide" style="background-color: {{'#'.$color['hexadecimal']}}">
								</div>
								<div class="text-uppercase color-hexa">
									{{'#'.$color['hexadecimal']}}
								</div>
							</div>
						@endif
					@endforeach
					</div>
			    </td> 
			  </tr>	
			  <tr>
			    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Colores secundarios</td>
			    <td>
				    <div class="colors-content">
				    @foreach($colors as $color)
						@if($color['type'] == 2)
							<div class="detail-color">
								<div class="color-bg-style-guide" style="background-color: {{'#'.$color['hexadecimal']}}">
								</div>
								<div class="text-uppercase color-hexa">
									{{'#'.$color['hexadecimal']}}
								</div>
							</div>
						@endif
					@endforeach
					</div>
			    </td> 
			  </tr>	
			  <tr>
			    <td style="text-align:center;color:#42c2b8;background-color:#F6F6F6">Tipografía</td>
			    <td>
				    <div class="colors-content">
				    @foreach($fonts as $font)
						<div class="detail-color-i">
							<div class="text-uppercase color-hexa">
								{{$font['name']}} - {{$font['size']}}
							</div>
						</div>
					@endforeach
					</div>
			    </td> 
			  </tr>				  


		</table>

		<div style="text-align:center; background-color:#F6F6F6">
			Generado con: 
			<img style="text-align:center;color:#42c2b8;witdh:10%" src="http://s11.postimg.org/duhv9zmv7/logo_sm.png">	
		</div>				
		
	</body>
</html>
