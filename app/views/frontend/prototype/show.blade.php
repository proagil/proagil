
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
									<div class="section-arrow-diag pull-right"></div>
								</div>							

							</div>	
							
							
							<div class="list-content">
								<!-- Menu top con elementos para grandar, borrar, exportar-->

								<div class="toolbar_container" >
									
									<button type="button" class="btn btn-default  btn-circle " id= 'undo-button' data-toggle="tooltip" data-placement="botton" title="Deshacer">
										 <p class=" fa fa-mail-reply fa_icons" > </p><br/>
									</button>
									<button type="button" class="btn btn-default btn-circle" id='redo-button' data-toggle="tooltip" data-placement="botton" title="Rehacer">
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
									<a  data-download= "{{$PrototypeName}}.png" id="btn-download"> 
										<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Exportar en PNG">
											 <p class="glyphicon glyphicon-save-file fa_icons" ></p>
										</button>
									 </a>

									<div class="separador" ></div>
									<button type="button" class="btn btn-default traer" data-toggle="tooltip" data-placement="bottom" title="Traer elemento al frente" onclick="traer()">
										 Traer al frente
									</button>

									<button type="button" class="btn btn-default llevar" data-toggle="tooltip" data-placement="bottom" title="Enviar elemento al fondo" onclick="llevar()">
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

								<!-- stencil con los elementos-->
								<div id="stencil-nav">
									<ul class="nav nav-tabs">
	  									<li role="presentation" id= "web" class="active" data-section="stencil-web"><a>Web</a></li>
	  									<li role="presentation" id= "movil" data-section="stencil-movil" ><a>Móvil</a></li>
	 									
									</ul>
								</div>
								<div  id="stencil-web">
									<div class="section-title-stencil ">

										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Menúes</div>
										<div data-section="section-menu" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>
									</div>	
									
									<div id="section-menu" class="showed section-menu">
										<div class="stencil_menu" ></div>
									 
									</div>

									<div class="section-title-stencil">

										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Botónes</div>
										<div data-section="section-button" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>

									</div>	
									
									<div id="section-button" class="showed section-button">
										<div class="stencil_button" ></div>
									 
									</div>
									<div class="section-title-stencil ">
										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Iconografía</div>
										<div data-section="section-icon" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>
									</div>	
									
									<div id="section-icon" class="showed section-icon">

										<div class="stencil_icon" ></div>
									 
									</div>
									<div class="section-title-stencil ">
										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Multimedia</div>
										<div data-section="section-multimedia" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>
									</div>	
									
									<div id="section-multimedia" class="showed section-icon">

										<div class="stencil_multimedia" ></div>
									 
									</div>
									<div class="section-title-stencil ">
										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Browser</div>
										<div data-section="section-browser" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>
									</div>	
									
									<div id="section-browser" class="showed section-browser">

										<div class="stencil_browser" ></div>
									 
									</div>


								</div>

								<div id= "stencil-movil">

									<div class="section-title-stencil-movil ">

										<div  style="font-size: 100%; font-weight: bold; text-align: center;">Android</div>
									</div>

									<div class="section-title-stencil ">

										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Dispositivo</div>
										<div data-section="section-disp" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>
									</div>
									<div id="section-disp" class="showed section-disp">

										<div class="stencil_disp" ></div>
									 
									</div>
									<div class="section-title-stencil ">

										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Misceláneos</div>
										<div data-section="section-misc" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>
									</div>
									<div id="section-misc" class="showed section-misc">

										<div class="stencil_misc" ></div>
									 
									</div>
									<div class="section-title-stencil-movil ">

										<div  style="font-size: 100%; font-weight: bold; text-align: center;">IOS</div>
									</div>
									<div class="section-title-stencil ">

										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Dispositivo</div>
										<div data-section="section-dispios" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>
									</div>
									<div id="section-dispios" class="showed section-dispios">

										<div class="stencil_dispios" ></div>
									 
									</div>

									
									<div class="section-title-stencil ">

										<div  class="pull-left" style="font-size: 100%; font-weight: bold;">Iconografía</div>
										<div data-section="section-iconios" class="section-arrow-diag pull-right">
											<i class="fc-turquoise fa fa-caret-down fa-fw"></i>
										</div>
									</div>
									<div id="section-iconpios" class="showed section-iconpios">

										<div class="stencil_iconios" ></div>
									 
									</div>


								</div>

								<div class="panel primario attributes-panel"  id="draggable">
								    <div class="cabecera"><h3>Atributos</h3></div>
								      <div class="cuerpo">
								          <div class="form-group atributos">
								            <label for="wh" data-tooltip="Tamaño del elemento">Tamaño</label>
								            <input id="wh"  type="range" value="1.00" step="0.1" min="10" max="1000" autocomplete="off"/>
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
