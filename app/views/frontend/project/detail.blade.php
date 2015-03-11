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
								Inicio <span class="fc-green"> &raquo; </span> Proyecto <span class="fc-green"> &raquo; </span> {{$project['name']}}
							</div>
							
							<div class="artefacts-content">
							
								<div class="section-title fc-blue-iii fs-big">
									Artefactos
									<div data-section="section-artefatcs" class="section-arrow pull-right"><i class="fc-green fa fa-caret-down fa-fw"></i></div>
								</div>
								
								<div id="section-artefatcs" class="showed section-artefatcs">
									<div class="fc-grey-ii fs-xxbig arrow-left prev">
										<i class="fa fa-chevron-left fa-fw"></i>
									</div>
								
									<div class="artefacts-list">								
										@if(!empty($projectArtefacts))
											@foreach($projectArtefacts as $projectArtefact)
											<div class="slide">
												<div class="artefact" data-friendly-url="{{$projectArtefact->friendly_url}}">
													<div class="artefact-icon">
														<img width="100%" src="{{URL::to('/').'/uploads/'.$projectArtefact->icon_file}}"/>
													</div>
													
													<div class="artefact-info">
														<div class="artefact-status">
															<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
														</div>
														<div class="artefact-name">
															{{$projectArtefact->name}}
														</div>
													</div>
												</div>
											</div>
											@endforeach
										@endif								
									</div>
									
									<div class="fc-grey-ii fs-xxbig arrow-left next">
										<i class="fa fa-chevron-right fa-fw"></i>
									</div>
								</div>
							</div>
							
							<div class="filters-content">
							
								<div class="section-title fc-blue-iii fs-big">
									Actividades
									<div class="section-arrow pull-right"><i class="fc-green fa fa-caret-down fa-fw"></i></div>
								</div>	

									{{ Form::open(array('action' => array('ProjectController@detail', $project['id']), 'id' => 'form-filter-activity')) }}
                     					 {{ Form::hidden('filters[category]', (isset($filters['category']))?$filters['category']:'') }}
                     					  {{ Form::hidden('filters[status]', (isset($filters['status']))?$filters['status']:'') }}
                   					{{Form::close()}}															
							
								<div class="fs-med tags-list">
									<span class="fs-big fc-pink fa fa-filter fa-fw"></span><span class="f-bold">Categor&iacute;a </span>
									

									<a href="#" data-category-id="ALL" class="hidden btn-filter tags-list-on">Todas</a>

									@if(!empty($activityCategories))
										@foreach($activityCategories as $activityCategory)
											<a href="#" data-category-id="{{$activityCategory->id}}" class="{{(in_array($activityCategory->id, $filtersArray))?'selected-tag tags-list-on':'unselected-tag tags-list-off'}} btn-filter">{{$activityCategory->name}}</a>
										@endforeach									
									@endif

									@if($projectOwner)
									<a href="{{URL::action('ActivityCategoryController@edit', array($project['id']))}}"><span class="fs-med fc-turquoise fa fa-cog fa-fw"></span><span class="fs-min">Configurar categor&iacute;as</span></a>
									@endif

								</div>
								
								<div class="fs-med tags-list tags-list-i">
									<span class="fs-big fc-pink fa fa-tasks fa-fw"></span><span class="f-bold">Estado </span>
									
									<a href="#" class="{{(in_array('1', $statusArray))?'selected-tag tags-list-on':'unselected-tag tags-list-off'}} btn-status" data-status-id="1"><i class="btn-change-activity-status fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>Sin empezar</a>
									<a href="#" class="{{(in_array('2', $statusArray))?'selected-tag tags-list-on':'unselected-tag tags-list-off'}} btn-status" data-status-id="2"><i class="btn-change-activity-status fs-big fa fa-check-circle fc-yellow fa-fw"></i>En proceso</a>
									<a href="#" class="{{(in_array('3', $statusArray))?'selected-tag tags-list-on':'unselected-tag tags-list-off'}} btn-status" data-status-id="3"><i class="btn-change-activity-status fs-big fa fa-check-circle fc-green fa-fw"></i>Terminadas</a>

								</div>
								@if($projectOwner)
								<div class=" fs-med common-btn btn-i btn-turquoise pull-right">
									<i class="fs-big fa fa-plus fa-fw"></i>Agregar actividad
								</div>
								@endif
							</div>	
							
							<div class="list-activities-content">
								@if(!empty($activities))
									@foreach($activities as $activity)
									<div class="btn-change-status">
										<i class="btn-change-activity-status fs-big fa fa-check-circle {{$activity['status_class']}} fa-fw" data-activity-id="{{$activity['id']}}" data-activity-status="{{$activity['status']}}"></i>	
									</div>
									<div class="activity" data-project-id="{{$project['id']}}" data-activity-id="{{$activity['id']}}">
										<div class="activity-info">
				
											<span class="{{($activity['status']==3)?'txt-strike':''}} activity-title-{{$activity['id']}}"> {{$activity['title']}} </title>
											
											<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>{{$activity['first_name']}}</span>
											
										</div>
										<div class="activity-description fc-grey-v" style="display:none" id="description-{{$activity['id']}}">
											<i class="fa fs-big fc-turquoise fa-file-o fa-fw"></i>
											{{$activity['description']}}
										</div>							
									</div>
									<div class="activity-options txt-center">
										@if($projectOwner)
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-pencil fa-fw"></i>
										</div>	
										@endif								
										<div class="circle activity-option txt-center fs-big fc-turquoise">
											<i class="fa fa-comments fa-fw"></i>
										</div>
										<div class="circle activity-option txt-center fs-big fc-turquoise close-activity btn-activity-description" data-activity-id="{{$activity['id']}}">
											<i class="fa fa-caret-down fa-fw"></i>
										</div>
									</div>										
									@endforeach
								@else
								<div class="f-min">Aun no hay actividades asociadas a este proyecto</div>
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

	      $('.activity').on('click', function(){

	      	var projectId = $(this).data('projectId'),
	      		activityId = $(this).data('activityId'), 

	      		windowLocation = "<?= URL::to('/')?>" 

	      	 	window.location.href = windowLocation+'/proyecto/'+projectId+'/actividad/'+activityId;

	      })

	  	});
	</script>
	</body>

</html>
