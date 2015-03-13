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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Sondeos <span class="fc-green"> &raquo; </span> Crear
							</div>							

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									Crear Sondeo
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							{{ Form::open(array('action' => array('ProbeController@save'), 'id' => 'form-create-probe')) }}	
							<input type="text" name="probe[title]" placeholder="Nombre del sondeo" class="probe-input-name probe-input form-control">	
							<textarea name="probe[description]" placeholder="Especifique una breve descripci&oacute;n para el Sondeo" class="probe-input-description probe-input form-control"></textarea>									

							<div class="list-content probe-questions-lists">
				 
								<div class="probe-options-question" style="display:none;">
									<div class="question-option">
										<input type="text" placeholder="Opcion" class="probe-input-option form-control"> 
										<div class="hidden circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-times fa-fw"></i>
										</div>	
										<div class="common-btn btn-mini txt-center btn-turquoise">Guardar</div>
										<div class="common-btn btn-mini txt-center btn-pink">Cancelar</div>										
									</div>
									<div class="question-option">
										<div class="show-quiestion-option">Opcion A</div>
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-pencil fa-fw"></i>
										</div>										
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-times fa-fw"></i>
										</div>											
									</div>	
									<div class="question-option">
										<input type="text" placeholder="Opcion" class="probe-input-option form-control">
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-times fa-fw"></i>
										</div>											
									</div>	
									<div class="btn-add-question-option">
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-plus fa-fw"></i>
										</div>																										
										<span class="probe-label"> Agregar opci&oacute;n</span>		
									</div>
								</div>																					
							</div>
							 {{Form::close()}}

							<div class="probe-general-buttons">

								<div class="save-probe txt-center fs-med common-btn btn-iii btn-turquoise pull-right txt-center">
									Guardar sondeo
								</div>									
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

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});
	</script>
	</body>

</html>
