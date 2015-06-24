
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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Prototipo
							</div>							

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="{{URL::action('UseCaseController@index', $projectId )}}" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									Prototipo: {{$PrototypeName}}
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							
							
							<div class="list-content">
								<!-- Menu top con elementos para grandar, borrar, exportar-->

								<div class="toolbar_container" >
									
									<button type="button" class="btn btn-default  btn-circle" data-toggle="tooltip" data-placement="bottom" title="Deshacer">
										 <p class=" fa fa-mail-reply fa_icons" > </p><br/>
									</button>
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Rehacer">
										 <p class="fa fa-share fa_icons"></p>  
									</button>
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Limpiar" onclick="eliminar()">
										 <p class=" glyphicon glyphicon-trash fa_icons"></p>
									</button>
									
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Eliminar">
										 <p class="glyphicon glyphicon-remove fa_icons" onclick="eliminarElemento()" ></p>
									</button>
									<button type="button" class="guardar btn btn-default btn-circle"  data-toggle="tooltip" data-placement="bottom" title="Guardar" onclick="guardar({{$PrototypeId}})" >
										 <p class="glyphicon glyphicon-floppy-disk fa_icons" ></p>
									</button>
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Exportar" onclick="exportar()">
										 <p class="glyphicon glyphicon-save-file fa_icons" ></p>
									</button>

									<div class="separador" ></div>
									<button type="button" class="btn btn-default traer" data-toggle="tooltip" data-placement="bottom" title="Traer elemento al frente" onclick="traer()">
										 Traer al frente
									</button>

									<button type="button" class="btn btn-default llevar" data-toggle="tooltip" data-placement="bottom" title="Enviar elemento al fondo" onclick="enviar()">
										 Enviar al fondo
									</button>

									<div class="separador2" ></div>
  									
  									<div class="atributos3">
									<span class="glyphicon glyphicon-zoom-out" ></span>
										 
										<input  id="sx" title='Zoom in/out' type="range" value="1.00" step="0.1" min="0.1" max="3" autocomplete="off">
																		
									</div>
									<div class= "zoom-in2">
										<span class="glyphicon glyphicon-zoom-in" ></span>

									</div>
									<div class= "menos2">
										<span class="fa fa-minus fa_icons" ></span>
										
									</div>
									<div id= "papersize2">

										<input id="ps" title='Tamaño del canvas' type="range" value="0" step="0.1" min="500" max="2000" autocomplete="off">

									</div>
									<div class= "mas2">
										<span class="fa fa-plus fa_icons" ></span>

									</div>
									
								</div>
								

								
								<!-- Canvas-->
								<div id="ident" name= '{{$PrototypeId}}' hidden ></div>
								<div class="paper" > </div>

								<!-- Menu derecho con elementos geometricos para hacer drag and drop
								<div class="stencil_container" >
								<ul class="nav nav-tabs">
  									<li role="presentation" class="active"><a href="#">Web</a></li>
  									<li role="presentation"><a href="#">Móvil</a></li>
 									
								</ul>

								</div>-->
								 
												
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

	@include('frontend.includes.prototypeJS')
	

	<script>


    $(function() {

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});


	</script>

	




	

	</body>

</html>
