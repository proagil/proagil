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

                    @if(isset($success_message))
                    	<div class="success-alert"><i class="fc-green glyphicon glyphicon-alert"></i> {{$success_message}}</div>
                	@endif

                    @if(isset($error_message))
                    	<div class="error-alert"><i class="fc-pink glyphicon glyphicon-alert"></i> {{$error_message}}</div>
                	@endif

                	<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="login-link"> Volver</a>
	                <div class="login-panel panel panel-default">
	                    <div class="panel-body">
	                          <?= Form::open(array('action' => 'LoginController@forgotPassword', 'id' => 'form-forgot-password')) ?> 
	                                <div class="form-group">
	                                    <?= Form::text('values[email]', (isset($values->email))?$values->email:'' , array('class' => 'app-input form-control', 'placeholder' => 'Correo Electr&oacute;nico')) ?>
	                                    <label class="error fc-pink fs-min" style="display:none"></label>
	                                    @if($errors->has('email'))
	                                    	<label class="error fc-pink fs-min">{{$errors->first('email')}}</label>
	                                    @endif
	                                </div>
	                                <div  class="common-btn btn-ii btn-turquoise txt-center btn-forgot-password">Enviar</div>
	                        <?=  Form::close() ?>
	                    </div>
	                </div>
	                
	            </div>
	        </div>
	    </div>		

	@include('frontend.includes.javascript')

	</body>

</html>
