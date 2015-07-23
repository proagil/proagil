
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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Diagrama de Objetos de Dominio
							</div>							

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="{{URL::action('DomainObjectController@index', array($projectId, $iterationId))}}" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									Título:
								</div>

								<div class="titulo-edit">
									<div class="question-title-{{$objectId}} titulo-object "><span class="fc-blue-i object-label-value"> {{$objectName}}</span>
									</div>
								
								</div>	


								<div data-object="{{$objectId}}" class="pull-right edit-object-info edit-object-info-default circle activity-option txt-center fs-big fc-yellow">
									<i class="fa fa-pencil fa-fw"></i>
								</div>

								<div class="hidden pull-right edit-object-info-save">									
									<div data-object="{{$objectId}}" class="cancel-edit-question-info common-btn btn-mini txt-center btn-pink pull-right">Cancelar</div>														
									<div data-object="{{$objectId}}" class="save-edit-object-info common-btn btn-mini txt-center btn-turquoise pull-right">Guardar</div>		      
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
										 <p class=" glyphicon glyphicon-file fa_icons"></p>
									</button>
									
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Eliminar">
										 <p class="glyphicon glyphicon-remove fa_icons" onclick="eliminarElemento()" ></p>
									</button>
									<button type="button" class="guardar btn btn-default btn-circle"  data-toggle="tooltip" data-placement="bottom" title="Guardar" onclick="guardar({{$objectId}})" >
										 <p class="glyphicon glyphicon-floppy-disk fa_icons" ></p>
									</button>
									<a  data-download= "{{$objectName}}.png" id="btn-download"> 
										<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Exportar a PNG">
											 <p class="glyphicon glyphicon-save-file fa_icons" ></p>
										</button>
									 </a>



									<div class= "separador"> </div> 

									<div id="conectores">

										<p class="titulos">Conectores</p>
										
									</div>
  									<div id="dropdownlineas" class= "contenedor"></div>

  									<div class="atributos2">
									<span class="glyphicon glyphicon-zoom-out" ></span>
										 
										<input  id="sx" title='Zoom in/out' type="range" value="1.00" step="0.1" min="0.1" max="3" autocomplete="off">
																		
									</div>
									<div id="acercar-alejar">

										<p class="titulos">Acercar/alejar</p>
										
									</div>
									<div class= "zoom-in">
										<span class="glyphicon glyphicon-zoom-in" ></span>

									</div>
									<div class= "menos">
										<span class="fa fa-minus fa_icons" ></span>
										
									</div>

									<div id="tamano">

										<p class="titulos">Tamaño del lienzo<p>
										
									</div>
									<div id= "papersize">

										<input id="ps" title='Tamaño del lienzo' type="range" value="0" step="0.1" min="500" max="2000" autocomplete="off">

									</div>
									<div class= "mas">
										<span class="fa fa-plus fa_icons" ></span>

									</div>


									
								</div>
								

								
								<!-- Canvas-->
								<div id="ident" name= '{{$objectId}}' hidden ></div>
								<div class="paper" > </div>

								<!-- Menu derecho con elementos geometricos para hacer drag and drop-->
								<div class="stencil_container" ></div>
								 
								 <div class="panel primario attributes-panel"  id="draggable">
								    <div class="cabecera"><h3>Atributos</h3></div>
								      <div class="cuerpo">
								          <div class="form-group atributos">
								            <label for="wh" data-tooltip="Tamaño del elemento">Tamaño</label>
								            <input id="wh"  type="range" value="1.00" step="0.1" min="90" max="400" autocomplete="off"/>
								          </div>
								          <div class="form-group atributos">
								            <label for="texto" data-tooltip="Texto del elemento">Nombre</label>
								         	<input id= "texto" class="form-control app-input" type="text" />
								          </div>
								          <div class="form-group atributos">
								             <label for="rotar" data-tooltip="Tamaño del elemento">Rotar</label>
								            <input id="rotar"  type="range" value="1.00" step="0" min="0" max="360" autocomplete="off" />
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

	@include('frontend.includes.ObjectJS')
	

	<script>


    $(function() {

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});

//////////////// Diferentes links a mostrar/////////////////////
    var ddData = [
    {
        
        value: 1,
        selected: false,
        imageSrc: "/images/LineaNormal.png"
    },
    {
        
        value: 2,
        selected: false,
        imageSrc: "/images/punteada.png"
    },
    {

        value: 3,
        selected: false,
        imageSrc: "/images/NormalPunta.png"
    },
    {

    	value: 4,
        selected: false,
        imageSrc: "/images/generalizacion.png"
    },
    {
    	value: 5,
        selected: false,
        imageSrc: "/images/LineaAgregacion.png"
    },
    {
    	value: 6,
        selected: false,
        imageSrc: "/images/LineaComposicion.png"
    }
    
	];

	//console.log(ddDATA);
    $('#dropdownlineas').ddslick({
    data: ddData,
    width: 100,
    imagePosition: "center",
    defaultSelectedIndex:3,


    onSelected: function (data) {
        var ddData = $('#dropdownlineas').data('ddslick');
       var index = ddData.selectedIndex;
       //console.log(data);
       
       document.getElementById("dropdownlineas").className= index;

   		
    }

  //  graph.fromJSON(JSON.parse(jsonString))


	});
////////////////////////////////////////////////////////////////////

/*Funcion que permite que el panel de atributos sea draggable*/
	$(function() {
   	 	$( "#draggable" ).draggable();
  	});



	</script>



	</body>

</html>
