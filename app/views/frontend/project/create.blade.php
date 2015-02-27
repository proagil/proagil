<html>
	<head>
	</head>

	<body>
		<h1> CREAR PROYECTO </h1>

		<?= Form::open(array('action' => 'ProjectController@create')) ?> <br>

			<?= Form::text('values[name]', (isset($values->name))?$values->name:'', array('placeholder' => 'Nombre del proyecto')) ?> <br>
			<?= ($errors->has('name'))?$errors->first('name'):''?><br>

			<?= Form::textarea('values[description]', (isset($values->description))?$values->description:'', array('placeholder' => 'Descripci&oacute;n')) ?> <br>
			<?= ($errors->has('description'))?$errors->first('description'):''?><br>

			<?= Form::select('values[project_type]', $projectTypes); ?> <br>

			@if (!is_null($artefacts))
				@foreach($artefacts as $artefact)

					<?=  Form::checkbox('values[artefacts][]', $artefact->id, FALSE);?> 
					<?= $artefact->name ?> <br>

				@endforeach
			@endif

			<?= Form::textarea('values[invitation]', (isset($values->invitation))?$values->invitation:'', array('placeholder' => 'Enviar invitaciones')) ?> <br>

			<?= Form::submit('Crear');?>


		<?=  Form::close() ?>

	</body>

</html>
