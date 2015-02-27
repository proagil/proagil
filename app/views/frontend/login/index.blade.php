<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>
	    <div class="container">
	        <div class="row">
	            <div class="col-md-4 col-md-offset-4">
					<div class="login-logo txt-center">
					   LOGO HERE
					</div>

                    @if(isset($error_message))
                    	<div class="error-alert"><i class="fc-pink glyphicon glyphicon-alert"></i> {{$error_message}}</div>
                	@endif

                	@if (Session::has('success_register'))
                		<div class="success-alert"><i class="fc-green glyphicon glyphicon-alert"></i> {{Session::get('success_register')}}</div>
                	@endif

	                <div class="login-panel panel panel-default">
	                    <div class="panel-body">
	                          <?= Form::open(array('action' => 'LoginController@index', 'id' => 'form-login')) ?> 
	                                <div class="form-group">
	                                    <?= Form::text('values[email]', (isset($values->email))?$values->email:'' , array('class' => 'app-input form-control', 'placeholder' => 'Correo Electr&oacute;nico')) ?>
	                                    <label class="error fc-pink fs-min" style="display:none"></label>
	                                    @if($errors->has('email'))
	                                    	<label class="error fc-pink fs-min">{{$errors->first('email')}}</label>
	                                    @endif
	                                </div>
	                                <div class="form-group">
                                    	<?= Form::password('values[password]', array('class' => 'app-input form-control', 'placeholder' => 'Contrase&ntilde;a')) ?>

	                                    <label class="error fc-pink fs-min" style="display:none"></label>
	                                    @if($errors->has('password'))
	                                    	<label class="error fc-pink fs-min">{{$errors->first('password')}}</label>
	                                    @endif
	                                </div>
	                                <div  class="common-btn btn-ii btn-turquoise txt-center btn-login">Entrar</div>
	                        <?=  Form::close() ?>
	                    </div>
	                    <i class="fc-green glyphicon glyphicon-question-sign"></i> <a class="login-link" href="{{URL::action('LoginController@forgotPassword')}}"> Olvid&eacute; mi contrase&ntilde;a</a><br>
	                    <i class="fc-green glyphicon glyphicon-share-alt"></i> <a class="login-link" href="{{URL::action('UserController@register')}}"> Registrarme </a>
	                </div>
	           
	                
	            </div>
	        </div>
	    </div>		

	@include('frontend.includes.javascript')

	</body>

</html>
