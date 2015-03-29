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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> An&aacute;lisis de sistemas existentes
							</div>							

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									An&aacute;lisis de sistemas existentes
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class=" fs-med common-btn btn-i btn-green pull-right">
								<a href="{{URL::action('ExistingSystemController@create', array($projectId))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear analisis</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($existingSystems))
									@foreach($existingSystems as $system)
									<div class="probe-item-content e-system" data-existing-system-id="{{$system['id']}}" style="width:92%;">
										<i class="fc-yellow fa fa-desktop fa-fw"></i>
											{{$system['name']}}
					
									</div>
									<div class="probe-options txt-center" style="width:8%;">
																		
										<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big fc-yellow">
											<a href="{{URL::action('ExistingSystemController@edit', array($system['id']))}}">
												<i class="fa fa-pencil fc-yellow fa-fw"></i>
											</a>
										</div>
										@if($projectOwner)
										<div data-existing-system-id="{{$system['id']}}" data-system-name="{{$system['name']}}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="circle activity-option txt-center fs-big fc-pink delete-esystem">
											<i class="fa fa-times fa-fw"></i>
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

      $('.e-system').on('click', function(){

      	var existingSystemId = $(this).data('existingSystemId');

      	 window.location.href = projectURL+'/analisis-sistemas-existentes/detalle/'+existingSystemId;

      })

      $('.delete-esystem').on('click', function(){

      		var existingSystemId = $(this).data('existingSystemId'),
      			systemName = $(this).data('systemName');

          var showAlert = swal({
            title: 'Eliminar sistema existente: '+systemName,
            text: 'Al eliminar un sistema existente se elimina toda su información asociada. ¿Realmente desea eliminarlo?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              window.location.href = projectURL+'/analisis-sistemas-existente/eliminar/'+existingSystemId;

          });               

      })      

  	});
	</script>

	</body>

</html>
