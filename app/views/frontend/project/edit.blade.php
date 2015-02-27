<html>
	<head>
	</head>

	<body>
		<h1> EDITAR PROYECTO </h1>

		<?= Form::open(array('action' => array('ProjectController@edit', $projectId)))?> <br>

			<?= Form::text('values[name]', (isset($values['name']))?$values['name']:'', array('placeholder' => 'Nombre del proyecto')) ?> <br>
			<?= ($errors->has('name'))?$errors->first('name'):''?><br>

			<?= Form::textarea('values[description]', (isset($values['description']))?$values['description']:'', array('placeholder' => 'Descripci&oacute;n')) ?> <br>
			<?= ($errors->has('description'))?$errors->first('description'):''?><br>

			<?= Form::select('values[project_type]', $projectTypes, $project->project_type_id); ?> <br>

			@if (!is_null($artefacts))

				@foreach($artefacts as $artefact)

					<?=  Form::checkbox('values[artefacts][]', $artefact->id, (in_array($artefact->id, $projectArtefacts))?TRUE:FALSE)?> 
					<?= $artefact->name ?> <br>

				@endforeach

			@endif

			<?= Form::textarea('values[invitation]', (isset($values['invitation']))?$values['invitation']:'', array('placeholder' => 'Enviar invitaciones')) ?> <br>

			<?= Form::submit('Editar');?>


		<?=  Form::close() ?>

	</body>

</html>
