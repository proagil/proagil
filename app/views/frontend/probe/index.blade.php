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

							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									Sondeos
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class=" fs-med common-btn btn-i btn-turquoise pull-right">
								<a href="{{URL::action('ProbeController@create', array($projectId))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear sondeo</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($probes))
									@foreach($probes as $probe)
									<div class="probe-item-content">
										<i class="fc-yellow fa fa-th-list fa-fw"></i>
											{{$probe['title']}}
										@if($probe['status']==1)
											<span class="fs-min"><i class="fs-med fa fa-lock fc-turquoise fa-fw"></i>Cerrado</span>
										@else
											<span class="fs-min"><i class="fs-med fa fa-unlock fc-turquoise fa-fw"></i>Abierto</span>
										@endif						
									</div>
									<div class="probe-options txt-center">
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<a target="_blank" href="{{URL::action('PublicProbeController@show', array($probe['url']))}}">
												<i class="fa fa-eye fa-fw"></i>
											</a>
										</div>
										@if($projectOwner)								
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-pencil fa-fw"></i>
										</div>
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-bar-chart-o fa-fw"></i>
										</div>
										<div class="circle activity-option txt-center fs-big fc-turquoise">
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

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});
	</script>
	</body>

</html>
