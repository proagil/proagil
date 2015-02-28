<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>
	    <div class="container">
	        <div class="row">
	            <div class="col-md-4 col-md-offset-4">
					<div class="login-logo txt-center">
					   <img src="{{URL::to('/').'/images/logo-sm.png'}}"/>
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
	                          <?= Form::open(array('action' => array('LoginController@changePassword', $token), 'id' => 'form-change-password')) ?> 
	                                <div class="form-group">
                                    	<?= Form::password('values[password]', array('class' => 'app-input form-control', 'placeholder' => 'Contrase&ntilde;a')) ?>

	                                    <label class="error fc-pink fs-min" style="display:none"></label>
	                                    @if($errors->has('password'))
	                                    	<label class="error fc-pink fs-min">{{$errors->first('password')}}</label>
	                                    @endif
	                                </div>
	                                <div class="form-group">
                                    	<?= Form::password('values[repeat_password]', array('class' => 'app-input form-control', 'placeholder' => 'Repetir contrase&ntilde;a')) ?>

	                                    <label class="error fc-pink fs-min" style="display:none"></label>
	                                    @if($errors->has('repeat_password'))
	                                    	<label class="error fc-pink fs-min">{{$errors->first('repeat_password')}}</label>
	                                    @endif
	                                </div>
	                                <div class="btn-content">	                                
	                                	<div  class="common-btn btn-ii btn-turquoise txt-center btn-change-password">Enviar</div>
	                                </div>
	                        <?=  Form::close() ?>
	                    </div>
	                </div>
	                
	            </div>
	        </div>
	    </div>		

	@include('frontend.includes.javascript')

	</body>

</html>
