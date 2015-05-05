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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span>  Iteraciones 
							</div>

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>														
		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
		
							<div class="filters-content">
								<div class="section-title fc-blue-iii fs-big">
								 	Iteraciones 
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class=" fs-med common-btn btn-i btn-green pull-right">
								<a href="{{URL::action('IterationController@create')}}">  <i class="fs-big fa fa-plus fa-fw"></i> Agregar iteraci&oacute;n</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($projectIterations))
									@foreach($projectIterations as $iteration)
									<div {{(!$projectOwner)?'style="width:96%;"':'style="width:92%;"'}} class="probe-item-content e-system" data-existing-system-id="{{$iteration['id']}}">
										<i class="fc-pink fa fa-rotate-right fa-fw"></i>
											Iteraci&oacute;n {{$iteration['order']}}: {{$iteration['name']}}
					
									</div>
									<div class="probe-options txt-center" {{(!$projectOwner)?'style="width:4%;"':'style="width:8%;"'}}>
																		
										<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big fc-yellow">
											<a href="{{URL::action('IterationController@edit', array($iteration['id']))}}">
												<i class="fa fa-pencil fc-yellow fa-fw"></i>
											</a>
										</div>
										@if($projectOwner)
										<div data-iteration-id="{{$iteration['id']}}" data-iteration-name="{{$iteration['name']}}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="circle activity-option txt-center fs-big fc-pink delete-iteration">
											<i class="fa fa-times fa-fw"></i>
										</div>												
										@endif								
									</div>									
									@endforeach
								@else
									<div class="txt-center fs-med"> <i class="fa  fa-frown-o fc-yellow fa-fw"></i> No hay iteraciones creados</div>
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
            confirmButtonText: 'Sí, eliminar',
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
