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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> {{$values['title']}} <span class="fc-green"> &raquo; </span> Editar
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			
							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text"></span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"> Success Alert</span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Editar Sondeo
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							{{ Form::open(array('action' => array('ProbeController@edit', $probeId), 'id' => 'form-create-probe')) }}	

								<div class="probe-info-edit-content">
									<div class="question-title-{{$probeId}} fc-turquoise">Titulo: <span class="fc-blue-i probe-label-value"> {{$values['title']}}</span>
									</div>
									
									<div class="question-status-{{$probeId}} fc-turquoise">Estado: <span class="fc-blue-i probe-label-value"> {{($values['status']==1)?'Cerrado':'Abierto'}} </span>
									</div>

									<div class="question-description-{{$probeId}} fc-turquoise">Descripci&oacute;n: <span class="fc-blue-i probe-label-value"> {{$values['description']}}</span>
									</div>
								</div>


								<div data-probe-id="{{$probeId}}" class="pull-right edit-probe-info edit-probe-info-default circle activity-option txt-center fs-big fc-turquoise">
									<i class="fa fa-pencil fa-fw"></i>
								</div>

								<div class="hidden pull-right edit-probe-info-save">									
									<div data-probe-id="{{$probeId}}" class="cancel-edit-question-info common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>														
									<div data-probe-id="{{$probeId}}" class="save-edit-probe-info common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>		      
								</div>									

								<div class="list-content probe-questions-lists">
									@if(!empty($values['elements']))
										@foreach($values['elements'] as $element)
											<div class="probe-question-content saved-question-{{$element['id']}}">
		                 						<label class="probe-label txt-right">Pregunta:</label>
		                 						<div class="probe-label probe-label-value question-title-{{$element['id']}}">{{$element['question']}}</div>
		  
		                  						<label class="probe-label txt-right">Tipo de pregunta:</label>
		                 						<div class="probe-label probe-label-value question-type-{{$element['id']}}"> {{$element['form_element_name']}} </div>

		                  						<label class="probe-label txt-right">Pregunta obligatoria:</label>
		                  						<div class="probe-label probe-label-value question-required-{{$element['id']}}">{{($element['required'])?'Si':'No'}}</div>
			                						
												<div class="pull-right edit-btn-question-options question-options-default-{{$element['id']}}">				
			                  						<div data-toggle="tooltip" data-placement="top" title="Eliminar" class="pull-right circle activity-option txt-center fs-big fc-pink delete-saved-question-element" data-question-id="{{$element['id']}}">
			                    						<i class="fa fa-times fa-fw"></i>
			                  						</div>  
			                  						<div data-toggle="tooltip" data-placement="top" title="Editar" class="pull-right circle activity-option txt-center fs-big fc-turquoise edit-question-element" data-question-id="{{$element['id']}}">
			                    						<i class="fa fa-pencil fa-fw"></i>
			                  						</div>  
												</div>

												<div class="pull-right edit-btn-question-options hidden question-options-edit-{{$element['id']}}">									
													<div data-question-id="{{$element['id']}}" class="cancel-edit-question common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>														
													<div data-question-id="{{$element['id']}}"  class="save-edit-question common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>		      
												</div>										
		              
		                					</div>

							                <div class="{{(empty($element['options']))?'hidden':''}} probe-options-question question-options-content-{{$element['id']}}">  
							                  <div class="all-options-content question-options-{{$element['id']}}">
							                  	@if(!empty($element['options']))
							                  		@foreach($element['options'] as $elementOption)
									                  	<div class="anwswer-option-content saved-option-{{$elementOption['id']}}">
					                  						<label class="probe-label txt-right">&nbsp;</label>
					                  						<label class="probe-label probe-label-value option-name-{{$elementOption['id']}}">{{ $elementOption['name']}}</label>
					                  						
					                  						<div class="edit-option-quiestion-content options-default-{{$elementOption['id']}}">
											                   <div data-option-id="{{$elementOption['id']}}"class="edit-probe-option circle activity-option txt-center fs-big fc-turquoise">
											                      <i class="fa fa-pencil fa-fw"></i>
											                    </div> 
											                   <div data-option-id="{{$elementOption['id']}}"class="delete-saved-probe-option circle activity-option txt-center fs-big fc-pink">
											                      <i class="fa fa-times fa-fw"></i>
											                    </div> 											                    
					                  						</div>

															<div class="hidden edit-option-quiestion-content options-edit-{{$elementOption['id']}}">
																<div data-option-id="{{$elementOption['id']}}"  class="save-edit-option common-btn btn-mini txt-center btn-turquoise">Guardar</div>																
																<div data-option-id="{{$elementOption['id']}}" class="cancel-edit-option common-btn btn-mini txt-center btn-pink">Cancelar</div>														
															</div>					                  						
									                  	</div>							                  		
							                  		@endforeach
							                  	@endif
							                 					                 
							                  </div>

							                  <div class="btn-add-question-option" data-question-id="'+questionCount+'">
							                   <div class="circle activity-option txt-center fs-big fc-turquoise">
							                      <i class="fa fa-plus fa-fw"></i>
							                    </div>                                         
							                    <span class="probe-label"> Agregar opci&oacute;n</span>   
							                  </div>
							                </div> 
							               @endforeach
							            @endif
					            </div>
							 {{Form::close()}}

							<div class="probe-general-buttons">								
								<div class="add-question-row fs-med common-btn btn-iii btn-turquoise pull-right txt-center">
									<a href="#">Agregar pregunta</a>
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

	var answerTypes = <?= json_encode($answerTypes) ?>; 

	</script>	


	{{ HTML::script('js/frontend/probe.js') }}

		<script>

	    $(function() {


	  	});

		</script>
	</body>

</html>
