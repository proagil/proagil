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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Sondeos
							</div>							

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									Diagrama de objetos de dominio
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class=" fs-med common-btn btn-i btn-turquoise pull-right">
								<a href="{{URL::action('ProbeController@create', array($projectId))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear sondeo</a>
							</div>
							@endif
							
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

										 <!--
									
										<input id="sx" type="range" value="1.00" step="0.1" min="0.1" max="3" autocomplete="off">
										        
									 
									<p class="glyphicon glyphicon-zoom-in fa_icons" ></p>-->
										 
									
									
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Guardar">
										 <p class="glyphicon glyphicon-floppy-disk fa_icons" ></p>
									</button>
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Exportar">
										 <p class="glyphicon glyphicon-save-file fa_icons" ></p>
									</button>

									<div class= "separador"> </div> 



									<!--<form role="form">
									    <div class="form-group dropdownlineas">
									      <select class="form-control lineas" id="sel1">
									        <option  data-content="<img src= ../images/LineaNormal.png>">hola</option>
									        <option value="">2</option>
									        <option value="">3</option>
									        <option value="">4</option>
									      </select>
									    </div>
  									</form>-->

  									<div id="dropdownlineas" class= "contenedor"></div>
																		


									
								</div>
								

								
								<!-- Canvas-->
								<div class="paper"> </div>

								<!-- Menu derecho con elementos geometricos para hacer drag and drop-->
								<div class="stencil_container" ></div>
								 
								 <div class="panel primario"  id="draggable">
								      <div class="cabecera"><h3>Atributos</h3></div>
								      <div class="cuerpo">
								        <div class="row">
								         
								         
								          <div class="form-group atributos">
								            <label for="wh" data-tooltip="Tamaño del elemento">Tamaño</label>
								            <input id="wh"  type="range" value="1.00" step="0.1" min="90" max="400" autocomplete="off"/>
								            
								          </div>
								          <div class="form-group atributos">
								          
								            <label for="texto" id="texto" data-tooltip="Texto del elemento">Texto</label>
								         <input id= "texto" class="form-control" type="text" value="texteando" />
								         
								      
								            
								          </div>
								          
								          
								       	 </div>
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
