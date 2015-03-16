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

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text">Error Alert</span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"> Success Alert</span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Crear Sondeo
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							{{ Form::open(array('action' => array('ProbeController@save'), 'id' => 'form-create-probe')) }}	

								<label class="probe-label txt-right">Titulo:</label>
							
								<input type="hidden" name="probe[project_id]" value="{{$projectId}}">	
								<input type="text" name="probe[title]"  class="probe-input-name probe-input form-control">	

								<label class="probe-label txt-right">Estado:</label>

								<select name="probe[status]" class="probe-input-status probe-input  form-control">
									<option value="1">Cerrado</option>
									<option value="2">Abierto</option>
								</select>

								<textarea name="probe[description]" placeholder="Especifique una breve descripci&oacute;n para el Sondeo" class="probe-input-description probe-input form-control"></textarea>																	

								<div class="list-content probe-questions-lists">
					 																				
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
