<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')

			<!-- Social media odal -->
			<div class="modal fade" id="modal-share-probe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content probe-share-modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="fs-big" aria-hidden="true">&times;</span></button>
			      </div>
			      <div class="modal-body">
			        <a class="share" href="#">share me</a>
			      </div>
			    </div>
			  </div>
			</div>	

			<div style="display:none" class="social-icons-container">
				<i style="color:#3b5998" class="share-option share-probe-facebook fs-xbig fa fa-facebook cur-point fa-fw"></i>
				<i style="color:#55acee" class="share-option share-probe-twitter fs-xbig fa fa-twitter cur-point  fa-fw"></i>
				<i style="color:#2672ae" class="share-option share-probe-linkedin fs-xbig fa fa-linkedin cur-point fa-fw"></i>
			</div>				


	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
						<div class="activities-content">
							<div class="breadcrumbs-content">
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span>  {{$iteration['name']}}  <span class="fc-green"> &raquo; </span> Prototipo
							</div>	

							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>													

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif	


		                	@if (Session::has('error_message'))
		                		<div class="error-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('error_message')}} </div>
		                	@endif	
							
							<div class="filters-content">
								<div class="section-title fc-blue-iii fs-big">
									Prototipos
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class="txt-center fs-med common-btn btn-i btn-green pull-right">
								<a href="{{URL::action('UseCaseController@create', array($projectId, $iteration['id']))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear diagrama</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($prototype))
									@foreach($prototype as $prototipo)
									<a href="#" data-toggle="modal" data-target="#imageModal-{{$prototipo['id']}}" >
										<div style="width:{{($projectOwner)?'81%':'96%'}}" class="use-case-item-content">
											<i class="fc-turquoise fa fa-circle-o fa-fw"></i>
											<span> {{$prototipo['title']}}</span>		
										</div>
									</a>	
									@if($projectOwner)	
									<div class="probe-options txt-center">
																	
										<div data-toggle="tooltip" data-placement="top" title="Editar" class=" edit-prototipo circle activity-option txt-center fs-big " id='identificado'data-prototipo-id="{{$prototipoId}}" >
											<a href="{{URL::action('PrototypeController@showdiagram', array($prototype['id'], $projectId, $iterationId))}}">
												<i class="fa fa-pencil fc-yellow fa-fw"></i>
											</a>
										</div>
										<div  data-prototipo-title="{{$prototype['title']}}" data-probe-url="" class="share-probe-popover circle activity-option txt-center fs-big fc-green">
											<i class="fa fa-share-alt fa-fw"></i>
										</div>
																			
										<div data-prototipo-title="{{$prototype['title']}}" data-prototipo-id="{{$prototype['id']}}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="delete-prototipo circle activity-option txt-center fs-big ">
											<i class="fa fa-times fc-pink fa-fw"></i>
										</div>																				
									</div>
									@endif									
									@endforeach
								@else
									<div class="txt-center fs-med"> <i class="fa  fa-frown-o fc-yellow fa-fw"></i> No hay diagramas creados</div>
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
	{{ HTML::script('js/frontend/probe.js') }}

	<script>

    $(function() {

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});

  	 $('.delete-prototipo').on('click', function(){

      		var prototipoId = $(this).data('prototipoId'),
      			prototipoTitle = $(this).data('prototipoTitle');

          var showAlert = swal({
            title: 'Eliminar Prototipo: '+prototipoTitle,
            text: 'Al eliminar el prototipo se elimina toda su información asociada. ¿Realmente desea eliminarlo?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              window.location.href = projectURL+'//prototipo/eliminar/'+prototipoId;

          });               

      })

	</script>
	</body>

</html>
