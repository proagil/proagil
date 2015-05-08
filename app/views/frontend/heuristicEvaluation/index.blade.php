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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> {{$iteration['name']}}  <span class="fc-green"> &raquo; </span> Evaluaci&oacute;n heur&iacute;stica
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>						

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Evaluaci&oacute;n heur&iacute;stica
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class=" fs-med common-btn btn-i btn-green pull-right">
								<a href="{{URL::action('HeuristicEvaluationController@create', array($projectId, $iteration['id']))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear evaluaci&oacute;n</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($evaluations))
									@foreach($evaluations as $evaluation)
									<div {{(!$projectOwner)?'style="width:96%;"':'style="width:92%;"'}} class="probe-item-content evaluation" data-evaluation-id="{{$evaluation['id']}}">
										<i class="fc-yellow fa fa-file-text fa-fw"></i>
											{{$evaluation['name']}}
					
									</div>
									<div class="probe-options txt-center" {{(!$projectOwner)?'style="width:4%;"':'style="width:8%;"'}}>
																		
										<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big fc-yellow">
											<a href="{{URL::action('HeuristicEvaluationController@edit', array($evaluation['id']))}}">
												<i class="fa fa-pencil fc-yellow fa-fw"></i>
											</a>
										</div>
										@if($projectOwner)
										<div data-evaluation-id="{{$evaluation['id']}}" data-evaluation-name="{{$evaluation['name']}}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="circle activity-option txt-center fs-big fc-pink delete-evaluation">
											<i class="fa fa-times fa-fw"></i>
										</div>												
										@endif								
									</div>									
									@endforeach
								@else
									<div class="txt-center fs-med"> <i class="fa  fa-frown-o fc-yellow fa-fw"></i> No hay evaluaciones heur&iacute;sticas creadas</div>								
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

      $('.evaluation').on('click', function(){

      	var evaluationId = $(this).data('evaluationId');

      	 window.location.href = projectURL+'/evaluacion-heuristica/detalle/'+evaluationId;

      })

      $('.delete-evaluation').on('click', function(){

      		var evaluationId = $(this).data('evaluationId'),
      			evaluationName = $(this).data('evaluationName');

          var showAlert = swal({
            title: 'Eliminar evaluación heurística: '+evaluationName,
            text: 'Al eliminar una evaluación heurística se elimina toda su información asociada. ¿Realmente desea eliminarla?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              window.location.href = projectURL+'/evaluacion-heuristica/eliminar/'+evaluationId;

          });               

      })      

  	});
	</script>

	</body>

</html>
