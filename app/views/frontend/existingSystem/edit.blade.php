<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')

	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
						<div class="activities-content">
							<div class="breadcrumbs-content">
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> {{$existingSystem['name']}} <span class="fc-green"> &raquo; </span> Editar
							</div>	

							<i class="fc-green glyphicon  glyphicon-chevron-left"> </i> <a href="{{URL::action('ExistingSystemController@index', array($projectId))}}" class="cur-point btn-back-i"> Volver</a>			
							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text"></span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"> Success Alert</span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Editar an&aacute;lisis de sistema existente
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
								<div class="probe-info-edit-content system-info-content">
									<div class="element-name-{{$existingSystemId}} fc-turquoise">Nombre: <span class="fc-blue-i probe-label-value"> {{$existingSystem['name']}}</span>
									</div>
									@if($existingSystem['interface_image']!=NULL)
									<div class="txt-center interface-preview">
										<img style="width:35%" src="{{URL::to('/').'/uploads/'.$existingSystem['interface_image']}}"/>
									</div>
									@endif
								</div>


								<div data-system-id="{{$existingSystemId}}" data-project-id="{{$projectId}}" class="pull-right edit-element-info edit-element-info-default circle activity-option txt-center fs-big fc-yellow">
									<i class="fa fa-pencil fa-fw"></i>
								</div>

								<div class="hidden pull-right edit-element-info-save">									
									<div data-project-id="{{$projectId}}" data-system-id="{{$existingSystemId}}" class="cancel-edit-element-info common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>														
									<div data-system-id="{{$existingSystemId}}" class="save-edit-element-info common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>		      
								</div>									

								<div class="list-content elements-list">
									@if(!empty($existingSystem['elements']))
										@foreach($existingSystem['elements'] as $element)
											<div class="probe-question-content saved-element-{{$element['id']}}">
		                 						<label class="probe-label txt-right">Caracter&iacute;stica:</label>
		                 						<div class="probe-label probe-label-value element-topic-{{$element['id']}}">{{$element['topic_name']}}</div>
		  
		                  						<label class="probe-label txt-right">Observaci&oacute;n:</label>
		                 						<div class="probe-label esystem-label-value element-obs-{{$element['id']}}"> {{$element['observation']}} </div>
			                						
												<div class="pull-right edit-btn-esystem-options element-options-default-{{$element['id']}}">				
			                  						<div data-toggle="tooltip" data-placement="top" title="Eliminar" class="pull-right circle activity-option txt-center fs-big fc-pink delete-saved-element" data-element-id="{{$element['id']}}">
			                    						<i class="fa fa-times fa-fw"></i>
			                  						</div>  
			                  						<div data-toggle="tooltip" data-placement="top" title="Editar" class="pull-right circle activity-option txt-center fs-big fc-yellow edit-element" data-element-id="{{$element['id']}}">
			                    						<i class="fa fa-pencil fa-fw"></i>
			                  						</div>  
												</div>

												<div class="pull-right edit-btn-esystem-options hidden element-options-edit-{{$element['id']}}">									
													<div data-element-id="{{$element['id']}}" class="cancel-edit-element common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>														
													<div data-element-id="{{$element['id']}}"  class="save-edit-element common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>		      
												</div>										
		              
		                					</div>
							               @endforeach
							            @endif
					            </div>

							<div class="probe-general-buttons">								
								<div data-project-id="{{$projectId}}" data-system-id="{{$existingSystemId}}" class="add-new-element-row fs-med common-btn btn-iii btn-turquoise pull-right txt-center">
									<a href="#">Nueva observaci&oacute;n</a>
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

	<script type="text/javascript">

	var topics = <?= json_encode($topics) ?>; 

	</script>	


	{{ HTML::script('js/frontend/esystem.js') }}

		<script>

	    $(function() {


	  	});

		</script>
	</body>

</html>
