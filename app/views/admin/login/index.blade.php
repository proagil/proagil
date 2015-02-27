<!DOCTYPE html>
<html lang="en">

 @include('admin.includes.head')

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default" style="margin:37% 0 0 0;">
                    <div class="panel-heading">
                        <h3 class="panel-title">App Name Admin</h3>
                    </div>
                    @if(isset($error_message))
                    	<div class="alert alert-danger"><i class="glyphicon glyphicon-remove-sign"></i> {{$error_message}}</div>
                	@endif
                    <div class="panel-body">
                       <?= Form::open(array('action' => 'AdminLoginController@index')) ?> 
                            <fieldset>
                                <div class="form-group">
                                    <?= Form::text('values[email]', (isset($values->email))?$values->email:'' , array('class' => 'form-control', 'placeholder' => 'Correo Electr&oacute;nico')) ?>
                                	<span class="help-block"><?= ($errors->has('email'))?$errors->first('email'):''?></span>  
                                </div>
                                <div class="form-group">
                                    <?= Form::password('values[password]', array('class' => 'form-control', 'placeholder' => 'Contrase&ntilde;a')) ?>
                                	<span class="help-block"><?= ($errors->has('password'))?$errors->first('password'):''?></span>  
                                </div>
                                <button class="btn btn-lg btn-success btn-block">Iniciar Sesi&oacute;n</button>
                            </fieldset>
                        <?=  Form::close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.includes.javascript')

</body>

</html>