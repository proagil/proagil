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

							<div class="e-system-table-head">
								<div class="system-name fs-big fc-green txt-center">
									Nombre del Sistema
								</div>
								<div class="system-interface txt-center">
 								<img  src="{{URL::to('/').'/uploads/'.Session::get('user')['avatar_file']}}"/>
								</div>
							</div>

							<div class="e-system-table-content">
								<div class="e-system-row">
									<div class="txt-center e-system-topic txt-center row-head">
										Caracter&iacute;stica
									</div>
									<div class="e-system-obs txt-center row-head">
										Observaci&oacute;n
									</div>
								</div>								
								<div class="e-system-row">
									<div class="txt-center e-system-topic">
										Opinion como usuario
									</div>
									<div class="e-system-obs">
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut dolor nunc. Nulla facilisi. Fusce at lectus et urna commodo pharetra ac eget felis. Nullam in consequat libero. Sed et tristique libero. Etiam sapien velit, dictum et tristique eu, rutrum at tortor. Aenean nisi magna, vestibulum nec iaculis ut, finibus sit amet purus. Vestibulum fringilla commodo justo, eu sollicitudin tortor varius consequat. Donec condimentum gravida mattis.
									</div>
								</div>
								<div class="e-system-row">
									<div class="txt-center e-system-topic">
										Opinion como usuario
									</div>
									<div class="e-system-obs">
										Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut dolor nunc. Nulla facilisi. a, vestibulum nec 
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


	{{ HTML::script('js/frontend/esystem.js') }}

	<script>

    $(function() {



  	});
	</script>
	</body>

</html>
