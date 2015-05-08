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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span>  {{$iteration['name']}}  <span class="fc-green"> &raquo; </span> {{$evaluation['name']}} <span class="fc-green"> &raquo; </span> Editar
							</div>	

							<i class="fc-green glyphicon  glyphicon-chevron-left"> </i> <a href="{{URL::action('HeuristicEvaluationController@index', array($projectId, $iteration['id']))}}" class="cur-point btn-back-i"> Volver</a>								
							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> <span class="error-alert-text"> </span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"></span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Editar evaluaci&oacute;n heur&iacute;stica
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
								<div class="probe-info-edit-content evaluation-info-content">
									<div class="element-name-{{$evaluationId}} fc-turquoise">Nombre: <span class="fc-blue-i probe-label-value"> {{$evaluation['name']}}</span>
									</div>
								</div>


								<div data-evaluation-id="{{$evaluationId}}" data-project-id="{{$projectId}}" class="pull-right edit-element-info edit-element-info-default circle activity-option txt-center fs-big fc-yellow">
									<i class="fa fa-pencil fa-fw"></i>
								</div>

								<div class="hidden pull-right edit-element-info-save">									
									<div data-project-id="{{$projectId}}" data-evaluation-id="{{$evaluationId}}" class="cancel-edit-element-info common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>														
									<div data-evaluation-id="{{$evaluationId}}" class="save-edit-element-info common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>		      
								</div>									

								<div class="list-content elements-list">
									@if(!empty($evaluation['elements']))
										@foreach($evaluation['elements'] as $element)
											<div class="probe-question-content saved-element-{{$element['id']}}">
		                 						<label class="probe-label txt-right">Heur&iacute;stica:</label>
		                 						<div class="probe-label evaluation-label-value element-heuristic-{{$element['id']}}">{{$element['heuristic_name']}}</div>
		  
		                  						<label class="probe-label txt-right">Problema:</label>
		                 						<div class="probe-label evaluation-label-value element-problem-{{$element['id']}}"> {{$element['problem']}} </div>

												<label class="probe-label txt-right">Valoraci&oacute;n:</label>
		                 						<div class="probe-label evaluation-label-value element-valoration-{{$element['id']}}">{{$element['valoration_name']}}</div>
		  
		                  						<label class="probe-label txt-right">Soluci&oacute;n:</label>
		                 						<div class="probe-label evaluation-label-value element-solution-{{$element['id']}}"> {{$element['solution']}} </div>		                 						
			                						
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
								<div data-project-id="{{$projectId}}" data-evaluation-id="{{$evaluationId}}" class="add-new-element-row fs-med common-btn btn-iii btn-turquoise pull-right txt-center">
									<a href="#">Agregar problema</a>
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

	var heuristics = <?= json_encode($heuristics) ?>; 
	var valorations = <?= json_encode($valorations) ?>; 

	</script>	


	{{ HTML::script('js/frontend/heuristic-evaluation.js') }}

		<script>

	    $(function() {


	  	});

		</script>
	</body>

</html>
