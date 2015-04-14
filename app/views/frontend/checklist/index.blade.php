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
								Inicio  <span class="fc-green"> &raquo; </span> {{$project['name']}}  <span class="fc-green"> &raquo; </span> Lista de Comprobación
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
									Lista de Comprobación
									<div class="section-arrow pull-right"></div>
								</div>							
							</div>	

							@if($projectOwner)
								<div class=" fs-med common-btn-i btn-iii btn-green pull-right btn-add-checklist" data-project-id="{{$project['id']}}">
									<i class="fs-big fa fa-plus fa-fw"></i>Crear lista de comprobación
								</div>
							@endif

							<div class="list-content">
							@if(!empty($checklists))
								@foreach($checklists as $checklist)
									
										@if($checklist['status']==2)
										<div data-checklist-id="{{$checklist['id']}}" class="checklist-status txt-center btn-checklist-show">
											<span class="fs-min pull-left"><i class="fs-med fa fa-check-square-o fc-green fa-fw"></i>Verificada</span>
										</div>
										@else
										<div data-checklist-id="{{$checklist['id']}}" class="checklist-status txt-center btn-checklist-verify">
											<span class="fs-min pull-left"><i class="fs-med fa fa-square-o fc-yellow fa-fw"></i>Por Verificar</span>
										</div>
										@endif	
									
									<div style="width:{{($projectOwner)?'82%':'90%'}}" class="checklist-item-content">
										<i class="fc-turquoise fa fa-list-ul fa-fw"></i>
											{{$checklist['title']}}					
									</div>
									
									@if($projectOwner)								
										<div class="checklist-options txt-center">
										@if($checklist['status']!=2)
											<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big fc-turquoise">
												<a href="{{URL::action('ChecklistController@edit', array($checklist['id']))}}">
													<i class="fa fa-pencil fc-yellow fa-fw"></i>
												</a>
											</div>
											<div data-checklist-id="{{$checklist['id']}}" data-toggle="tooltip" data-placement="top" title="Eliminar"  class="circle activity-option txt-center fs-big fc-pink btn-checklist-delete" >
												<i class="fa fa-times fa-fw"></i>
											</div>
										@else
											<div data-checklist-id="{{$checklist['id']}}" data-checklist-title="{{$checklist['title']}}"data-toggle="tooltip" data-placement="top" title="Eliminar" style="margin: 0px 5px 0 2px" class="circle activity-option txt-center fs-big fc-pink pull-right btn-delete-checklist">
												<i class="fa fa-times fa-fw"></i>
											</div>
										@endif
										</div>												
									@endif								
																		
								@endforeach
							@else
								<div class="f-min">Aún no  han creado listas de comprobación</div>
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

	</body>

</html>
