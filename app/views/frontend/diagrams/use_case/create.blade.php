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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> {{$iteration['name']}}  <span class="fc-green"> &raquo; </span>  Diagrama de Casos de Uso <span class="fc-green"> &raquo; </span> Crear
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="{{URL::action('UseCaseController@index', array($projectId, $iterationId))}}" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text">Error Alert</span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"> Success Alert</span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Crear Diagrama
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							{{ Form::open(array('action' => array('UseCaseController@save'), 'id' => 'form-create-use-case')) }}	

								<label class="use-case-label txt-right">T&iacute;tulo:</label>
							
								<input type="hidden" name="use_case[project_id]" value="{{$projectId}}">
								<input type="hidden" name="use_case[iteration_id]" value="{{$iteration['id']}}">	
								<input type="text" name="use_case[title]"  class="use_case-input-name use-case-input form-control">	
								
							 {{Form::close()}}

							<div class="probe-general-buttons">

								<div class="save-usecase txt-center fs-med common-btn btn-iii btn-green pull-right txt-center">
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
