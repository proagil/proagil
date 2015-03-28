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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Sondeos
							</div>							

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif	


		                	@if (Session::has('error_message'))
		                		<div class="error-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('error_message')}} </div>
		                	@endif	
							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									Sondeos
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class=" fs-med common-btn btn-i btn-green pull-right">
								<a href="{{URL::action('ProbeController@create', array($projectId))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear sondeo</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($probes))
									@foreach($probes as $probe)
									<div class="probe-item-content" data-probe-url="{{$probe['url']}}">
										<i class="fc-green fa fa-th-list fa-fw"></i>
											{{$probe['title']}}		

											@if($probe['status']==1)
												<i class="fc-turquoise fa fa-lock fa-fw"></i> Cerrado
											@else
												<i class="fc-turquoise fa fa-unlock fa-fw"></i> Abierto
											@endif				
									</div>
									<div class="probe-options txt-center">
										@if($projectOwner)								
										<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big ">
											<a href="{{URL::action('ProbeController@edit', array($probe['id']))}}">
												<i class="fa fa-pencil fc-yellow fa-fw"></i>
											</a>
										</div>
										<div data-toggle="tooltip" data-placement="top" title="Estadisticas" class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-bar-chart-o fa-fw"></i>
										</div>
										<div data-probe-title="{{$probe['title']}}" data-probe-id="{{$probe['id']}}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="delete-probe circle activity-option txt-center fs-big ">
											<i class="fa fa-times fc-pink fa-fw"></i>
										</div>												
										@endif								
									</div>									
									@endforeach
								@endif				
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

      $('.probe-item-content').on('click', function(){

      	 probeUrl = $(this).data('probeUrl');

      	 window.location.href = projectURL+'/sondeo/generar/'+probeUrl;

      })

      $('.delete-probe').on('click', function(){

      		var probeId = $(this).data('probeId'),
      			probeTitle = $(this).data('probeTitle');

          var showAlert = swal({
            title: 'Eliminar Sondeo: '+probeTitle,
            text: 'Al eliminar un sondeo se elimina toda su información asociada. ¿Realmente desea eliminarlo?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              window.location.href = projectURL+'/sondeo/eliminar/'+probeId;

          });               

      })

  	});
	</script>
	</body>

</html>
