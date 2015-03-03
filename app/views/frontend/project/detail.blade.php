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
								
								<div id="section-artefatcs" class="show">
									<div class="fc-grey-ii fs-xxbig arrow-left">
										<i class="fa fa-chevron-left fa-fw"></i>
									</div>
								
									<div class="artefacts-list">
										@if(!empty($projectArtefacts))
											@foreach($projectArtefacts as $projectArtefact)
											<div class="artefact">
												<div class="artefact-icon">
													<img width="100%" src="{{URL::to('/').'/images/dummy-activity.png'}}"/>
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
											@endforeach
										@endif								
									</div>
									
									<div class="fc-grey-ii fs-xxbig arrow-left">
										<i class="fa fa-chevron-right fa-fw"></i>
									</div>
								</div>
							</div>
							
							<div class="filters-content">
							
								<div class="section-title fc-blue-iii fs-big">
									Actividades
									<div class="section-arrow pull-right"><i class="fc-green fa fa-caret-down fa-fw"></i></div>
								</div>							
							
								<div class="fs-med tags-list">
									<span class="fs-big fc-pink fa fa-filter fa-fw"></span><span class="f-bold">Filtros </span>
									
									<a class="tags-list-off">Dise&ntilde;o</a>
									<a class="tags-list-off">Bases de Datos</a>
									<a class="tags-list-off">Administraci&oacute;n</a>
									<a class="tags-list-off">Administraci&oacute;n</a>
									@if($projectOwner)
									<a href="#"><span class="fs-med fc-turquoise fa fa-cog fa-fw"></span><span class="fs-min">Configurar filtros</span></a>
									@endif

								</div>
								
								<div class="fs-med tags-list tags-list-i">
									<span class="fs-big fc-pink fa fa-tasks fa-fw"></span><span class="f-bold">Estado </span>
									
									<a class="unmade-off">Sin empezar</a>
									<a class="in-process-off">En proceso</a>
									<a class="made-off">Terminadas</a>
								</div>
								@if($projectOwner)
								<div class=" fs-med common-btn btn-i btn-turquoise pull-right">
									<i class="fs-big fa fa-plus fa-fw"></i>Agregar tarea
								</div>
								@endif
							</div>	
							
							<div class="list-activities-content">
								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										Suspendisse faucibus nunc sed magna maximus, vel auctor nulla
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>						
							
								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										Lorem ipsum dolor amet un net atret tid atret
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-down fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>
								
								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										Suspendisse faucibus nunc sed magna maximus, vel auctor nulla
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>	

								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										Suspendisse faucibus nunc sed magna maximus, vel auctor nulla
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>

								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										consectetur adipiscing elit
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>	

								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										Suspendisse consectetur adipiscing elit auctor nulla
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											@if($projectOwner)
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>
											@endif									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>	

								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										Suspendisse faucibus nunc sed magna
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>	
								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										Suspendisse faucibus nunc sed magna maximus, vel auctor nulla
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>	

								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										consectetur adipiscing elit maximus, vel auctor nulla
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>								

								<div class="activity">
									<div class="activity-info">
										<i class="fs-big fa fa-check-circle fc-grey-iv fa-fw"></i>
										consectetur adipiscing elit maximus, vel auctor nulla
										
										<span class="fs-min"><i class="fs-med fa fa-user fc-turquoise fa-fw"></i>Ma. Francis Malav&eacute;</span>
										
										<div class="activity-options pull-right">
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-pencil fa-fw"></i>
											</div>									
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-comments fa-fw"></i>
											</div>
											<div class="circle activity-option txt-center fs-big fc-turquoise">
												<i class="fa fa-caret-right fa-fw"></i>
											</div>
										</div>
									</div>
									<div class="activity-description fc-grey-iv hidden">
										<i class="fa fs-big fc-yellow fa-file-o fa-fw"></i>
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at justo vitae ante fermentum pharetra. Aliquam blandit in magna quis dapibus. Morbi finibus eleifend nunc non lacinia. Nullam ultrices dolor vitae orci semper consectetur. Suspendisse faucibus nunc sed magna maximus, vel auctor nulla convallis.Pellentesque purus neque, maximus et ultricies vitae, aliquam a lorem. Phasellus pulvinar vulputate elementum. Cras dignissim augue sed maximus ultricies. Proin elit turpis, imperdiet a accumsan sed, ornare ac velit. 
									</div>							
								</div>							
							
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
	</body>

</html>
