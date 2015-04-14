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
								Inicio  <span class="fc-green"> &raquo; </span> {{Session::get('project')['name']}}  <span class="fc-green"> &raquo; </span> {{$probeTitle}} <span class="fc-green"> &raquo; </span> Resultados
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text">Error Alert</span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"> Success Alert</span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Resultados
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
															

							<div class="list-content">
								@foreach($graphicsArray as $index => $graphic)

								<div id="graphic-{{$index}}"></div>
								@piechart('graphic-'.$index, 'graphic-'.$index)	

								@endforeach
																						
							</div>

							<div class="list-content">
								@if(!empty($openQuestions))
									@foreach($openQuestions as $question)
									<div class="probe-result-question-row">
										<div class="result-question f-bold">
											{{$question['question']}}
										</div>
										@if(!empty($question['results']))
											@foreach($question['results'] as $answer)
											<div class="result-answer">
												{{$answer}}
											</div>
											@endforeach
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

	{{ HTML::script('js/frontend/probe.js') }}

	<script>

    $(function() {


  	});
	</script>
	</body>

</html>