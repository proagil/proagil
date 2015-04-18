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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Gu&iacute;a de estilos <span class="fc-green"> &raquo; </span> {{$styleGuide['name']}} <span class="fc-green"> &raquo; </span> Detalle
							</div>	

							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>			

							<div class="error-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="error-alert-text"></span> </div>	

							<div class="success-alert-dashboard hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i><span class="success-alert-text"></span> </div>		

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							
	
							<div class="filters-content">
							 
								<div class="section-title fc-blue-iii fs-big">
									Detalle gu&iacute;a de estilos
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	

							<div class="text-center fc-turquoise f-bold fs-big text-uppercase">{{$styleGuide['name']}}</div>

							<div class="e-system-table-content">
								@if($styleGuide['interface']!='')
								<div class="e-system-row">
									<div class="txt-center f-bold f-big fc-turquoise text-uppercase e-system-topic">
										Interfaz de usuario
									</div>
									<div class="e-system-obs f-bold f-med txt-center">
										<div class="system-interface txt-center">
		 									<img  style="width:60%;" src="{{URL::to('/').'/uploads/'.$styleGuide['interface_image']}}"/>
										</div>										
									</div>
								</div>
								@endif

								@if($styleGuide['logo']!='')
								<div class="e-system-row">
									<div class="txt-center f-bold f-big fc-turquoise text-uppercase e-system-topic">
										Logo
									</div>
									<div class="e-system-obs f-bold f-med txt-center">
										<div class="system-interface txt-center">
		 									<img  src="{{URL::to('/').'/uploads/'.$styleGuide['logo_image']}}"/>
										</div>										
									</div>
								</div>
								@endif		

								@if(!empty($styleGuide['colors']))
								<div class="e-system-row">
									<div class="txt-center f-bold f-big fc-turquoise text-uppercase e-system-topic">
										Colores primarios
									</div>
									<div class="colors-content">
										@foreach($styleGuide['colors'] as $color)
											@if($color['type'] == 1)
												<div class="detail-color">
													<div class="color-bg-style-guide" style="background-color: {{'#'.$color['hexadecimal']}}">
													</div>
													<div class="text-uppercase  color-hexa">
														{{'#'.$color['hexadecimal']}}
													</div>
												</div>

											@endif
										@endforeach										
									</div>
								</div>
								@endif

								@if(!empty($styleGuide['colors']))
								<div class="e-system-row">
									<div class="txt-center f-bold f-big fc-turquoise text-uppercase e-system-topic">
										Colores Secundarios
									</div>
									<div class="colors-content">
										@foreach($styleGuide['colors'] as $color)
											@if($color['type'] == 2)
												<div class="detail-color">
													<div class="color-bg-style-guide" style="background-color: {{'#'.$color['hexadecimal']}}">
													</div>
													<div class="text-uppercase  color-hexa">
														{{'#'.$color['hexadecimal']}}
													</div>
												</div>

											@endif
										@endforeach										
									</div>
								</div>
								@endif	

								@if(!empty($styleGuide['fonts']))
								<div class="e-system-row">
									<div class="txt-center f-bold f-big fc-turquoise text-uppercase e-system-topic">
										Tipograf&iacute;a
									</div>
									<div class="e-system-obs">
										@foreach($styleGuide['fonts'] as $font)
											{{$font['name']}} - {{$font['size']}} <br>
										@endforeach										
									</div>
								</div>
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


	{{ HTML::script('js/frontend/esystem.js') }}

	<script>

    $(function() {



  	});
	</script>
	</body>

</html>
