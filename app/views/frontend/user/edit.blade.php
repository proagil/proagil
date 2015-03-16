<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')

	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
        						<div class="section-content">
        							<div class="breadcrumbs-content">
        								Inicio <span class="fc-green"> &raquo; </span> Editar perfil 
        							</div>
                      <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
        							<div class="section-title fc-blue-iii fs-big">
        								Editar perfil
        							</div>

                      <div class="form-content">
                        {{ Form::open(array('action' => array('UserController@edit', $userId), 'files' => true, 'id' => 'form-edit-user-profile')) }}	
                          <div class="form-group">
                            <label class="col-md-4 title-label control-label" for="textinput">&nbsp;</label>  
                            <div class="col-md-4">
                              <div class="edit-profile-img txt-center">
                                  @if (isset($values['avatar_file']))
                                    <img width="50%" src="{{URL::to('/').'/uploads/'.$values['avatar_file']}}"/>
                                  @else
                                    <img width="50%" src="{{URL::to('/').'/images/dummy-user.png'}}"/>

                                  @endif
                              </div>
                                  <?= Form::file('avatar', array('id'=>'avatar', 'class' => 'file-upload file-upload-edit', 'title' => 'Cambiar avatar', 'data-filename-placement' => 'inside'))?>
                            </div>
                          </div>							

                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Nombre</label>  
                            <div class="col-md-4">
                              {{ Form::text('values[first_name]', (isset($values['first_name']))?$values['first_name']:'', array('class'=>'form-control app-input')) }}
                              <span class="error fc-pink fs-min"><?= ($errors->has('first_name'))?$errors->first('first_name'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Apellido</label>  
                            <div class="col-md-4">
                              {{ Form::text('values[last_name]', (isset($values['last_name']))?$values['last_name']:'',  array('class'=>'form-control app-input')) }}
                              <span class="error fc-pink fs-min"><?= ($errors->has('last_name'))?$errors->first('last_name'):''?></span>  
                            </div>
                          </div>	                               	                        					<div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Correo electr&oacute;nico</label>  
                            <div class="col-md-4">
                              {{ Form::text('values[email]', (isset($values['email']))?$values['email']:'', array('class'=>'form-control app-input', 'disabled' => 'disabled')) }}
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Contrase&ntilde;a</label>  
                            <div class="col-md-4">
                              {{Form::password('values[password]', array('class'=>'form-control app-input'))}}                    
                              <span class="error fc-pink fs-min"><?= ($errors->has('password'))?$errors->first('password'):''?></span>  
                            </div>
                          </div>
                           <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Repetir contrase&ntilde;a</label>  
                            <div class="col-md-4">
                              {{Form::password('values[repeat_password]', array('class'=>'form-control app-input'))}}  
                              <span class="error fc-pink fs-min"><?= ($errors->has('repeat_password'))?$errors->first('repeat_password'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                               <div class="col-md-4 btn-save-dashboard common-btn btn-ii btn-turquoise txt-center btn-edit-user-profile">Guardar</div> 
                          </div>
                         
                          {{Form::close()}}
                      </div>	                              	                               	   				
        						</div>
					       </div>
	                <!-- /.col-lg-12 -->
	            </div>
	            <!-- /.row -->
	        </div>
	        <!-- /#page-wrapper -->
	    </div>
	    <!-- /#wrapper -->

	@include('frontend.includes.javascript')
	</body>

</html>
