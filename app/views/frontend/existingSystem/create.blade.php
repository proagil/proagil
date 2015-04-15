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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> An&aacute;lisis de sistemas existentes <span class="fc-green"> &raquo; </span> Crear
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text">Error Alert</span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"> Success Alert</span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Crear an&aacute;lisis de sistema existente
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							{{ Form::open(array('action' => array('ExistingSystemController@save'), 'files' => true, 'id' => 'form-create-esystem')) }}	

								<label class="probe-label txt-right">Nombre:</label>
							
								<input type="hidden" name="esystem[project_id]" value="{{$projectId}}">	
								<input type="text" name="esystem[name]"  class="probe-input-name probe-input form-control">	

								<label class="probe-label txt-right">Interfaz:</label>

	                            {{ Form::file('interface', array('id'=> 'interface', 'class'=> 'file-upload file-upload-e-system', 'title' => 'Subir imagen', 'data-filename-placement' => 'inside')) }}															

								<div class="list-content esystem-lists">
					 																				
								</div>
							 {{Form::close()}}

							<div class="probe-general-buttons">

								<div class="save-esystem txt-center fs-med common-btn btn-iii btn-green pull-right txt-center">
									Guardar
								</div>									
								<div class="add-esystem-row fs-med common-btn btn-iii btn-turquoise pull-right txt-center">
									<a href="#">Agregar observaci&oacute;n</a>
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

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});
	</script>
	</body>

</html>
