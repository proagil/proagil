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
        								Inicio <span class="fc-green"> &raquo; </span> Editar Proyecto
        							</div>
                   
        							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif      

                    <div class="error-alert-dashboard error-alert hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> <span class="error-text"> Verifique los campos obligatorios</span></div>                      
                      
                      <div class="section-title fc-blue-iii fs-big">
        								Editar Proyecto
        							</div>

                     <div class="question-number text-center f-bold fs-fmed text-uppercase"><i class="fs-big fc-green fa fa-folder-open fa-fw"></i>  Informaci&oacute;n de proyecto </div>                      

                      <div class="form-content">
                        {{ Form::open(array('action' => array('ProjectController@editInfo', $projectId), 'id' => 'form-edit-project-info')) }}				
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Nombre <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4">
                              {{ Form::text('values[name]', (isset($values['name']))?$values['name']:'', array('class'=>'form-control app-input')) }}

                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('name'))?$errors->first('name'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Objetivos <span class="fc-pink fs-med"></span></label>  
                            <div class="col-md-4">
                              {{ Form::textarea('values[objetive]', (isset($values['objetive']))?$values['objetive']:'', array('class'=>'form-control app-input', 'rows' => '3')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('objetive'))?$errors->first('objetive'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Cliente <span class="fc-pink fs-med"></span></label>  
                            <div class="col-md-4">
                              {{ Form::text('values[client]', (isset($values['client']))?$values['client']:'', array('class'=>'form-control app-input')) }}

                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('client'))?$errors->first('client'):''?></span>  
                            </div>
                          </div> 
                           <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput"></label>  
                            <div class="col-md-4">
                              <div class="btn-edit-project-info txt-center fs-med common-btn btn-iii btn-yellow pull-right txt-center">
                                Editar proyecto
                              </div>     
                            </div>
                          </div>                              

                          <div class="probe-general-buttons">
                         
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
