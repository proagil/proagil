<!DOCTYPE html>
<html>

	@include('frontend.includes.head')
	{{ HTML::style('css/frontend/colpick.css') }}


	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')


	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
						<div class="activities-content">
							<div class="breadcrumbs-content">
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span>  {{$iteration['name']}}  <span class="fc-green"> &raquo; </span>  Gu&iacute;a de estilos <span class="fc-green"> &raquo; </span> Crear
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text"></span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"></span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Crear gu&iacute;a de estilos
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							{{ Form::open(array('action' => array('StyleGuideController@save'), 'files' => true, 'id' => 'form-save-guide-style')) }}
								<input name="values[project_id]" type="hidden" value="{{$projectId}}">
								<input name="values[iteration_id]" type="hidden" value="{{$iteration['id']}}">								

							<div class="style-guide-content">
								<div class="style-guide-tabs-content">
									<div class="txt-center tab tab-on" data-tab-name="information">
										<i class="fs-med fc-yellow fa fa-info-circle fa-fw"></i> Informaci&oacute;n
									</div>
									<div class="txt-center tab tab-off" data-tab-name="colors">
										<i class="fs-med fc-turquoise fa fa-tint fa-fw"></i>  Paleta de colores
									</div>
									<div class="txt-center tab tab-off" data-tab-name="fonts">
										<i class="fs-med fc-green fa fa-font fa-fw"></i>  Tipograf&iacute;a
									</div>	
									<div class="txt-center tab tab-off" data-tab-name="interface">
										<i class="fs-med fc-pink fa fa-desktop fa-fw"></i>  Interfaz de usuario
									</div>																					
								</div>
								<div class="style-guide-section-content">
									<div class="style-guide-section" id="section-information">
			                          <div class="form-group style-guide-form-group">
			                            <label class="col-md-4 title-label control-label" for="textinput">Nombre de la aplicaci&oacute;n <span class="fc-pink fs-med">*</span></label>  
			                            <div class="col-md-4">
			                              {{ Form::text('values[name]', (isset($values['name']))?$values['name']:'', array('class'=>'form-control app-input', 'data-input-type' => 'information')) }}

			                              <label class="error fc-pink fs-min hidden">Debe indicar un nombre de aplicaci&oacute;n</label>
			                              <span class="error fc-pink fs-min"><?= ($errors->has('name'))?$errors->first('name'):''?></span>  
			                            </div>
			                          </div>
			                          <div class="form-group style-guide-form-group">
			                            <label class="col-md-4 title-label control-label" for="textinput">Logo</label>
			                            <div class="col-md-4">
     									 {{ Form::file('logo', array('id'=> 'logo', 'class'=> 'file-upload', 'title' => 'Selecciona una imagen', 'data-filename-placement' => 'inside')) }}
			                            </div>
			                          </div>			                          
									</div>
									<div class="style-guide-section hidden" id="section-colors">
			                          <div class="form-group style-guide-form-group">
			                            <label class="col-md-4 title-label control-label" for="textinput">Colores primarios</label>
			                            <div class="col-md-4">
				                            <div class="primary-color-content">
											</div>																			
			                            </div>
			                          </div>
			                          <div class="form-group">
			                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">&nbsp;</label>  
			                            <div class="col-md-4">
			                              <div class="btn-add-color">
			                                <div class="circle activity-option txt-center fs-big fc-turquoise">
			                                  <i class="fa fa-plus fa-fw"></i>
			                                </div>
			                                <span class="fs-min cur-point">Hacer clic para agregar color primario</span> 
			                              </div>
			                            </div> 
			                          </div>
			                          <div class="form-group style-guide-form-group">
			                            <label class="col-md-4 title-label control-label" for="textinput">Colores secundarios</label>
			                            <div class="col-md-4">
				                            <div class="secundary-color-content">
											</div>																			
			                            </div>
			                          </div>
			                          <div class="form-group">
			                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">&nbsp;</label>  
			                            <div class="col-md-4">
			                              <div class="btn-add-secundary-color cur-point">
			                                <div class="circle activity-option txt-center fs-big fc-turquoise">
			                                  <i class="fa fa-plus fa-fw"></i>
			                                </div>
			                                <span class="fs-min">Hacer clic para agregar color secundario</span> 
			                              </div>
			                            </div> 
			                          </div>				                          			                          

									</div>							
									<div class="style-guide-section hidden" id="section-fonts">
										<div class="fonts-content">								
										</div>
		                          		
			                          <div class="form-group">
			                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">&nbsp;</label>  
			                            <div class="col-md-4">
			                              <div class="add-new-font cur-point" style="margin:5%">
			                                <div class="circle activity-option txt-center fs-big fc-turquoise">
			                                  <i class="fa fa-plus fa-fw"></i>
			                                </div>
			                                <span class="fs-min">Hacer clic para agregar otra fuente</span> 
			                              </div>
			                            </div> 
			                          </div>
									</div>
									<div class="style-guide-section hidden" id="section-interface">
			                          <div class="form-group style-guide-form-group">
			                            <label class="col-md-4 title-label control-label" for="textinput">Interfaz </label>
			                            <div class="col-md-4">
     									 {{ Form::file('interface', array('id'=> 'interface', 'class'=> 'file-upload', 'title' => 'Selecciona una imagen', 'data-filename-placement' => 'inside')) }}
			                            </div>
			                          </div>
									</div>									
								</div>								
							</div>

							 {{Form::close()}}

							<div class="probe-general-buttons">

								<div class="save-style-guide txt-center fs-med common-btn btn-iii btn-turquoise pull-right txt-center">
									Guardar
								</div>									
						
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

	{{ HTML::script('js/frontend/style-guide.js') }}
	{{ HTML::script('js/frontend/colpick.js') }}

	<script>

    $(function() {

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })
 

  	});
	</script>
	</body>

</html>
