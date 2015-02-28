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

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
							
								<div class="section-title fc-blue-iii fs-big">
									Proyectos creados por mi
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							
							<div class="list-content">
							@if(!empty($ownerProjects))
								@foreach($ownerProjects as $project)
								<div class="activity">
									<div class="list-item activity-info">
										<i class="fc-yellow fa fa-folder-open fa-fw"></i>
											{{$project->name}}
									</div>						
								</div>
								@endforeach
							@else
								No tiene ning&uacute;n proyecto creado. Para crear uno hacer clic <a href="{{URL::action('ProjectController@create')}}">aqu&iacute;</a>
							@endif 																
							</div>

							
							<div class="filters-content">
							
								<div class="section-title section-title-green fc-blue-iii fs-big">
									Proyectos en los que colaboro
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							<div class="list-content">
							@if(!empty($memberProjects))
								@foreach($memberProjects as $project)
								<div class="activity">
									<div class="list-item activity-info">
										<i class="fc-green fa fa-folder-open fa-fw"></i>
										{{$project->name}}
									</div>						
								</div>	
								@endforeach	
							@else
							A&uacute;n no eres colaborador en ning&uacute;n proyecto 																									
							</div>	
							@endif												
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
	</body>

</html>
