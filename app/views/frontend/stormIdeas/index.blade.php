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
								Inicio  <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span> {{$iteration['name']}}  <span class="fc-green"> &raquo; </span> Tormenta de Ideas
							</div>	

							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="{{URL::action('ProjectController@detail', array($project['id'], $iteration['id']))}}" class="btn-back-i"> Volver</a>													
		                	@if (Session::has('error_message'))
		                		<div class="error-alert-dashboard"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('error_message')}}</div>
		                	@endif	
		                	
		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
							
							<div class="filters-content">
								<div class="section-title fc-blue-iii fs-big">
									Tormenta de Ideas
									<div class="section-arrow pull-right"></div>
								</div>							
							</div>


							@if($projectOwner)
								<div class="txt-center fs-med common-btn-i btn-iii btn-green pull-right btn-add-storm-ideas" data-project-id="{{$project['id']}}"  data-iteration-id="{{$iteration['id']}}">
									<i class="fs-big fa fa-plus fa-fw"></i> Crear Tormenta de Ideas
								</div>
							@endif

							<div class="list-content">
							@if(!empty($stormsIdeas))
								@foreach($stormsIdeas as $stormIdeas)
									<a href="#" data-toggle="modal" data-target="#imageModal-{{$stormIdeas['id']}}" >
										<div style="width:{{($projectOwner)?'92%':'95%'}}" class="storm-ideas-item-content">
											<i class="fc-turquoise fa fa-cloud fa-fw"></i>{{$stormIdeas['name']}}
										</div>
									</a>	
									<!-- INIT MODAL HTML TO SHOW STORM IDEAS -->
									<div class="modal fade" id="imageModal-{{$stormIdeas['id']}}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
									    <div class="modal-dialog">
									        <div class="modal-content" style="border-radius:0px;">
									            <div class="modal-header" style="border-bottom: 0px;">
										            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="fs-med fa fa-times fc-pink fa-fw"></i></button>
										            <h4 class="fs-med text-center f-bold fc-turquoise" id="myModalLabel">{{$stormIdeas['name']}}</h4>
									            </div>
									            <div class="modal-body">
						                            <div class="col-md-12">
						                              <div class="txt-center">
					                                    <img id="storm-image-{{$stormIdeas['id']}}" width="100%" src="{{URL::to('/').'/uploads/'.$stormIdeas['storm_ideas_image']}}"/>
						                              </div>
						                            </div>
									            </div>
									            <div class="modal-footer" style="border-top: 0px;">

									        	</div>
										        <div class="modal-footer" style="border-top: 0px">
										        	<div class="pull-right btn-download-storm-ideas common-btn btn-ii btn-turquoise txt-center"> 
										        		<a id="download-{{$stormIdeas['id']}}" href="{{URL::to('/').'/uploads/'.$stormIdeas['storm_ideas_image']}}" download="{{$stormIdeas['name']}}.png">
										        		<i class="fa fa-cloud-download fa-fw"></i> Descargar
										        	 	</a>
										        	</div>
										        </div>									    
									    	</div>
									  	</div>
									</div>
									<!-- END MODAL HTML TO SHOW STORM IDEAS -->	
									
									@if($projectOwner)								
										<div class="storm-ideas-options txt-center">
											<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big fc-turquoise">
												<a href="{{URL::action('StormIdeasController@edit', array($stormIdeas['id']))}}">
													<i class="fa fa-pencil fc-yellow fa-fw"></i>
												</a>
											</div>
											<div data-storm-ideas-title="{{$stormIdeas['name']}}"  data-storm-ideas-id="{{$stormIdeas['id']}}" data-toggle="tooltip" data-placement="top" title="Eliminar"  class="circle activity-option txt-center fs-big fc-pink btn-delete-storm-ideas" >
												<i class="fa fa-times fa-fw"></i>
											</div>
										</div>
									@else
										<div class="storm-ideas-options txt-center" style="width:5%">
											<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big fc-turquoise">
												<a href="{{URL::action('StormIdeasController@edit', array($stormIdeas['id']))}}">
													<i class="fa fa-pencil fc-yellow fa-fw"></i>
												</a>
											</div>
										</div>

									@endif								
																		
								@endforeach
							@else
								<div class="txt-center fs-med"> <i class="fa  fa-frown-o fc-yellow fa-fw"></i> No hay tormentas de ideas creadas</div>
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
