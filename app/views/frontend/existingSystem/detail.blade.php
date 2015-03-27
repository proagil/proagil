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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> An&aacute;lisis de sistemas existentes <span class="fc-green"> &raquo; </span> {{$existingSystem['name']}}
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text">Error Alert</span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"> Success Alert</span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									{{$existingSystem['name']}}
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($existingSystem['interface']!='')
							<div class="e-system-table-head">
								<div class="system-interface txt-center">
 									<img  src="{{URL::to('/').'/uploads/'.$existingSystem['interface_image']}}"/>
								</div>
							</div>
							@endif

							<div class="e-system-table-content">
								<div class="e-system-row">
									<div class="txt-center f-bold f-med e-system-topic row-head">
										Caracter&iacute;stica
									</div>
									<div class="e-system-obs f-bold f-med txt-center row-head">
										Observaci&oacute;n
									</div>
								</div>	
								@foreach($existingSystem['elements'] as $existingSystem)							
								<div class="e-system-row">
									<div class="txt-center e-system-topic">
										{{$existingSystem['topic_name']}}
									</div>
									<div class="e-system-obs">
										{{$existingSystem['observation']}}
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


	{{ HTML::script('js/frontend/esystem.js') }}

	<script>

    $(function() {



  	});
	</script>
	</body>

</html>
