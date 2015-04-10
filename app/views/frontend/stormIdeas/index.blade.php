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
								Inicio  <span class="fc-green"> &raquo; </span> {{$project['name']}}  <span class="fc-green"> &raquo; </span> Tormenta de Ideas
							</div>							

		                	@if (Session::has('error_message'))
		                		<div class="error-alert-dashboard"><i class="fc-pink glyphicon glyphicon-alert"></i> {{Session::get('error_message')}}</div>
		                	@endif	
		                	
		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									Tormenta de Ideas
									<div class="section-arrow pull-right"></div>
								</div>							
							</div>


							@if($projectOwner)
								<div class=" fs-med common-btn-i btn-iii btn-green pull-right btn-add-storm-ideas" data-project-id="{{$project['id']}}">
									<i class="fs-big fa fa-plus fa-fw"></i> Crear Tormenta de Ideas
								</div>
							@endif

							<div class="list-content">
							@if(!empty($stormsIdeas))
								@foreach($stormsIdeas as $stormIdeas)
									
									<div style="width:{{($projectOwner)?'90%':'100%'}}" class="storm-ideas-item-content">
										<i class="fc-turquoise fa fa-cloud fa-fw"></i>
											{{$stormIdeas['name']}}					
									</div>
									
									@if($projectOwner)								
										<div class="storm-ideas-options txt-center">
											<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big fc-turquoise">
												<a href="{{URL::action('StormIdeasController@edit', array($stormIdeas['id']))}}">
													<i class="fa fa-pencil fc-yellow fa-fw"></i>
												</a>
											</div>
											<div data-storm-ideas-id="{{$stormIdeas['id']}}" data-toggle="tooltip" data-placement="top" title="Eliminar"  class="circle activity-option txt-center fs-big fc-pink btn-storm-ideas-delete" >
												<i class="fa fa-times fa-fw"></i>
											</div>
										</div>												
									@endif								
																		
								@endforeach
							@else
								<div class="f-min">Aún no han creado tormentas de ideas</div>
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

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});

	</script>
	</body>

</html>
