<html>

	@include('frontend.includes.head')

	<body>
		<h1> EDITAR PERFIL DE USUARIO </h1>


		<?= Form::open(array('action' => array('UserController@edit', $userId), 'files' => true)) ?> <br>

		<img class="img-circle" src="{{URL::to('/').'/uploads/'.$values['avatar_file']}}"/> <br>
		<?= Form::file('avatar','', array('id'=>'avatar'))?> <br>

			<?= Form::text('values[first_name]', (isset($values['first_name']))?$values['first_name']:'', array('placeholder' => 'Nombre')) ?> <br>
			<?= ($errors->has('first_name'))?$errors->first('first_name'):''?><br>

			<?= Form::text('values[last_name]', (isset($values['last_name']))?$values['last_name']:'', array('placeholder' => 'Apellido')) ?> <br>
			<?= ($errors->has('last_name'))?$errors->first('last_name'):''?><br>

			<?= Form::text('values[email]', (isset($values['email']))?$values['email']:'', array('placeholder' => 'Email', 'disabled' => 'disabled')) ?> <br>
			<?= ($errors->has('email'))?$errors->first('email'):''?><br>

			<?= Form::password('values[password]', array('placeholder' => 'Contraseña')) ?> <br>
			<?= ($errors->has('password'))?$errors->first('password'):''?><br>

			<?= Form::password('values[repeat_password]', array('placeholder' => 'Repetir Contraseña')) ?> <br>
			<?= ($errors->has('repeat_password'))?$errors->first('repeat_password'):''?><br>

			<?= Form::submit('Enviar');?>


		<?=  Form::close() ?>

	</body>

</html>
