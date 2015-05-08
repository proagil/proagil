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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> {{$iteration['name']}}  <span class="fc-green"> &raquo; </span> Evaluaci&oacute;n heur&iacute;stica <span class="fc-green"> &raquo; </span> {{$evaluation['name']}} <span class="fc-green"> &raquo; </span> Detalle 
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text"></span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"></span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Detalle evaluaci&oacute;n heur&iacute;stica
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	

							<div class="text-center fc-turquoise f-bold fs-big text-uppercase">{{$evaluation['name']}}</div>

							<div class="btn-export pull-right">
								<a class="unselected-tag tags-list-off" href="{{URL::action('HeuristicEvaluationController@export', array($evaluation['id']))}}"><span class="fs-med fc-turquoise fa fa-cloud-download fa-fw"></span><span class="fs-min">Exportar</span></a>
							</div>							

							<div class="heuristic-evaluation-table-content">
								<div class="heuristic-evaluation-row">
									<div class="txt-center f-bold f-med heuristic-evaluation-value heuristic-evaluation-head row-head">
										Problema
									</div>
									<div class="txt-center f-bold f-med heuristic-evaluation-value heuristic-evaluation-head row-head">
										Heur&iacute;stica
									</div>
									<div class="txt-center f-bold f-med heuristic-evaluation-value heuristic-evaluation-head row-head">
										Valoraci&oacute;n
									</div>
									<div class="txt-center f-bold f-med heuristic-evaluation-value heuristic-evaluation-head row-head">
										Soluci&oacute;n
									</div>														
								</div>
								@foreach($evaluation['elements'] as $element)	
								<div class="heuristic-evaluation-row">
									<div class="f-med heuristic-evaluation-value">
										{{$element['problem']}}
									</div>
									<div class="txt-center f-med heuristic-evaluation-value">
											{{$element['heuristic_name']}}
									</div>
									<div class="txt-center f-med heuristic-evaluation-value">
										{{$element['valoration_name']}}
									</div>
									<div class="f-med heuristic-evaluation-value">
										{{$element['solution']}}
									</div>														
								</div>
								@endforeach																				
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


	{{ HTML::script('js/frontend/heuristic-evaluation.js') }}

	<script>

    $(function() {



  	});
	</script>
	</body>

</html>
