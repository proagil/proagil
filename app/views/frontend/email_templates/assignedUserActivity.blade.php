<html>
	<head>
	</head>

	<body>
		<h1> NOTIFICACIÓN DE ACTIVIDAD ASIGNADA </h1>

		<p>Hola {{$assigned_user_name}} !!!</p>

		<p>{{$user_name}} te ha asignado la actividad {{$activity_title}}, para obtener más información haz clic aqui <a href="{{$url_token}}"> aqui</a></p>

		Si no puedes ver el enlace copia la siguiente dirección en la barra de URL <br>

		{{$url_token}}

	</body>

</html>
