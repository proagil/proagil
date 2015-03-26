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
			  line-height: 1.6;
			}

			img {
				display: block;
				margin-left: auto;
				margin-right: auto;
				width: 20%;
			}

			body {
			  -webkit-font-smoothing: antialiased;
			  -webkit-text-size-adjust: none;
			  width: 100%;
			  height: 100%;

			}

			/* -------------------------------------
				TYPOGRAPHY
			------------------------------------- */
			h3 {
			  font-family: "sans-serif", sans-serif;
			  margin-bottom: 15px;
			  color: #000;
			  margin: 40px 0 10px;
			  line-height: 1.6;
			  font-weight: bold;
			  font-size: 22px;
			}

			p {
			  margin-bottom: 10px;
			  font-weight: normal;
			  font-size: 14px;

			}

		</style>
	</head>

	<body>
		<table class="body-wrap">
			<tr>
			<td></td>
			<td class="container" bgcolor="#F6F6F6" style="padding: 25px 50px 25px 50px">
				<div class="content">
					<table>
						<tr>
							<td>
								<a href='http://postimage.org/' target='_blank'><img src='http://s11.postimg.org/duhv9zmv7/logo_sm.png' border='0' alt="logo sm" /></a>
								<h2 style="text-align:center;color:#42c2b8" >ACTIVAR CUENTA</h2> 
								<h3>¡¡¡ Hola <font style = "text-transform: capitalize">{{$user_name}}</font> !!!</h3>
								<p style="line-height: 1.6" >Para activar tu cuenta debes hacer clic en el siguiente botón:</p>
								<br>
								<i style="float: right">
									<a href="{{$url_token}}" style=" text-decoration: none;
																	color: #FFF;
																	background-color: #a8d76f;
																	border: solid #a8d76f;
																	border-width: 10px 20px;
																	line-height: 0;
																	font-weight: bold;
																	margin-right: 10px;
																	text-align: center;
																	cursor: pointer;" >Activar Cuenta
									</a>
								</i>

								<br>
								<br>
								<p style="line-height: 1.6">Si no puedes ver el enlace copia la siguiente dirección en la barra de URL: <a style="color:#42C2B8; text-decoration:none; font-weight: bold" href="{{$url_token}}">{{$url_token}}</p> 
								<br>
							</td>
						</tr>

					</table>
				</div>
			</td>
			<td></td>
		  </tr>
		</table>
	</body>
</html>
