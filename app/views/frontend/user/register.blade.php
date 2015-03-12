<html>

	@include('frontend.includes.head')

	<body>
	    <div class="container">
	        <div class="row">
	            <div class="col-md-4 col-md-offset-4">
					<div class="login-logo txt-center">
					   <img src="{{URL::to('/').'/images/logo-sm.png'}}"/>
					</div>


                    @if(isset($error_message))
                    	<div class="error-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{$error_message}}</div>
                	@endif

                    @if(isset($success_message))
                    	<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{$success_message}}</div>
                	@endif  

                	<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="{{URL::to('/')}}" class="login-link"> Volver</a>
	                <div class="login-panel panel panel-default">
	                    <div class="panel-body">
	                    	  <div class="login-title txt-center fs-med">
	                    	  		Registro <br>
	                    	  		<span class="fs-min"><span class="fc-pink fs-med">*</span> Campos obligatorios</span>
	                    	  </div>	  	                    	
                          {{ Form::open(array('action' => 'UserController@register', 'files' => true, 'id' => 'form-register'))}} 
	                            <div class="form-group">
	                                {{ Form::text('values[first_name]', (isset($values['first_name']))?$values['first_name']:'', array('class' => 'app-input app-input-i form-control', 'placeholder' => 'Nombre'))}} <span class="fc-pink fs-med">*</span> 
	                                <label class="error fc-pink fs-min" style="display:none"></label>
	                                @if($errors->has('first_name'))
	                                	<label class="error fc-pink fs-min">{{$errors->first('first_name')}}</label>
	                                @endif
	                            </div>
	                            <div class="form-group">
	                                {{ Form::text('values[last_name]', (isset($values['last_name']))?$values['last_name']:'', array('class' => 'app-input form-control app-input-i', 'placeholder' => 'Apellido'))}} <span class="fc-pink fs-med">*</span>
	                                <label class="error fc-pink fs-min" style="display:none"></label>
	                                @if($errors->has('last_name'))
	                                	<label class="error fc-pink fs-min">{{$errors->first('last_name')}}</label>
	                                @endif
	                            </div>	
	                            <div class="form-group">
	                                {{ Form::file('avatar', array('id'=> 'avatar', 'class'=> 'file-upload', 'title' => 'Selecciona tu avatar', 'data-filename-placement' => 'inside')) }}
	                            </div>		                                
	                            <div class="form-group">
	                                {{ Form::text('values[email]', (isset($values['email']))?$values['email']:'', array('class' => 'app-input form-control app-input-i', 'placeholder' => 'Correo electr&oacute;nico'))}} <span class="fc-pink fs-med">*</span>
	                                <label class="error fc-pink fs-min" style="display:none"></label>
	                                @if($errors->has('email'))
	                                	<label class="error fc-pink fs-min">{{$errors->first('email')}}</label>
	                                @endif
	                            </div>
	                            <div class="form-group">
	                                {{ Form::password('values[password]' , array('class' => 'app-input form-control app-input-i', 'placeholder' => 'Contraseña')) }} <span class="fc-pink fs-med">*</span>
	                                <label class="error fc-pink fs-min" style="display:none"></label>
	                                @if($errors->has('password'))
	                                	<label class="error fc-pink fs-min">{{$errors->first('password')}}</label>
	                                @endif
	                            </div>
	                            <div class="form-group">
	                                {{ Form::password('values[repeat_password]' , array('class' => 'app-input form-control app-input-i', 'placeholder' => 'Repetir contraseña')) }} <span class="fc-pink fs-med">*</span>
	                                <label class="error fc-pink fs-min" style="display:none"></label>
	                                @if($errors->has('repeat_password'))
	                                	<label class="error fc-pink fs-min">{{$errors->first('repeat_password')}}</label>
	                                @endif
	                            </div>	
	                             <div class="btn-content">			                                		                                		                                                                
	                            	<div  class="common-btn btn-ii btn-turquoise txt-center btn-register">Registrarme</div>
	                            </div>
                        {{Form::close()}} 
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>	

		@include('frontend.includes.javascript')

	</body>

</html>
