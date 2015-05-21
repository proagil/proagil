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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> {{$iteration['name']}}  <span class="fc-green"> &raquo; </span>  Gu&iacute;a de estilos
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>													

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
								<div class="section-title fc-blue-iii fs-big">
									Gu&iacute;a de estilos
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div style="width:160px" class=" fs-med common-btn btn-i btn-green pull-right">
								<a href="{{URL::action('StyleGuideController@create', array($projectId,$iteration['id']))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear gu&iacute;a de estilos</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($stylesGuide))
									@foreach($stylesGuide as $styleGuide)
									<div {{(!$projectOwner)?'style="width:96%;"':'style="width:89%;"'}} class="probe-item-content style-guide" data-style-guide-id="{{$styleGuide['id']}}">
										<i class="fc-pink fa  fa-file-photo-o fa-fw"></i>
											{{$styleGuide['name']}}
					
									</div>
									<div class="probe-options txt-center" {{(!$projectOwner)?'style="width:4%;"':'style="width:11%;"'}}>
																		
										<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big fc-yellow">
											<a href="{{URL::action('StyleGuideController@edit', array($styleGuide['id']))}}">
												<i class="fa fa-pencil fc-yellow fa-fw"></i>
											</a>
										</div>
										@if($projectOwner)
										<div data-style-guide-id="{{$styleGuide['id']}}" data-style-guide-name="{{$styleGuide['name']}}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="btn-delete-style-guide circle activity-option txt-center fs-big fc-pink">
											<i class="fa fa-times fa-fw"></i>
										</div>												
										@endif								
									</div>									
									@endforeach
								@else
									<div class="txt-center fs-med"> <i class="fa  fa-frown-o fc-yellow fa-fw"></i> No hay gu&iacute;as de estilos creadas</div>
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
	{{ HTML::script('js/frontend/style-guide.js') }}
	{{ HTML::script('js/frontend/colpick.js') }}

	<script>

    $(function() {

      $('.style-guide').on('click', function(){

      	var styleGuideId = $(this).data('styleGuideId');

      	 window.location.href = projectURL+'/guia-de-estilos/detalle/'+styleGuideId;

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

              window.location.href = projectURL+'/guia-de-estilos/eliminar/'+existingSystemId;

          });               

      })      

  	});
	</script>

	</body>

</html>
