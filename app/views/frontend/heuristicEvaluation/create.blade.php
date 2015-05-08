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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span>  {{$iteration['name']}}  <span class="fc-green"> &raquo; </span> Evaluaci&oacute;n heur&iacute;stica <span class="fc-green"> &raquo; </span> Crear
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text"></span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"></span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Crear evaluaci&oacute;n heur&iacute;stica
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							{{ Form::open(array('action' => array('HeuristicEvaluationController@save'), 'id' => 'form-create-esystem')) }}	

								<label class="probe-label txt-right">Nombre:</label>
							
								<input type="hidden" name="evaluation[project_id]" value="{{$projectId}}">
								<input type="hidden" name="evaluation[iteration_id]" value="{{$iteration['id']}}">	
								<input type="text" name="evaluation[name]"  class="evaluation-title probe-input-name probe-input form-control">																

								<div class="list-content evaluation-list">
					 																				
								</div>
							 {{Form::close()}}

							<div class="probe-general-buttons">

								<div class="save-evaluation txt-center fs-med common-btn btn-iii btn-green pull-right txt-center">
									Guardar
								</div>									
								<div class="add-element-row fs-med common-btn btn-iii btn-turquoise pull-right txt-center">
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

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});
	</script>
	</body>

</html>
