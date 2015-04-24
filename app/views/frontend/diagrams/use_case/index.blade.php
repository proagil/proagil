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
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Diagrama de Casos de Uso
							</div>							

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif							

							
							<div class="filters-content">
							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
								<div class="section-title fc-blue-iii fs-big">
									Diagrama de Casos de Uso
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
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Limpiar">
										 <p class=" glyphicon glyphicon-trash fa_icons"></p>
									</button>
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Aumentar">
										 <p class="glyphicon glyphicon-zoom-in fa_icons" ></p>
									</button>
									<button type="button" class="btn btn-default btn-circle" data-toggle="tooltip" data-placement="bottom" title="Disminuir">
										 <p class="glyphicon glyphicon-zoom-out fa_icons" ></p>
									</button>
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

								<!-- Menu derecho con elementos geometricos para hacer drag and drop-->
								
								<div class="paper"> 



								</div>

								<div class="stencil_container" >
									
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

	@include('frontend.includes.js_diagramas')
	

	<script>

    $(function() {

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});


    var ddData = [
    {
        
        value: 1,
        selected: false,
        imageSrc: "../images/LineaNormal.png"
    },
    {
        
        value: 2,
        selected: false,
        imageSrc: "../images/punteada.png"
    },
    {

        value: 3,
        selected: false,
        imageSrc: "../images/NormalPunta.png"
    }
];

    $('#dropdownlineas').ddslick({
    data: ddData,
    width: 100,
    imagePosition: "center",
    defaultSelectedIndex:3,

    onSelected: function (data) {
        var ddData = $('#dropdownlineas').data('ddslick');
       var index = ddData.selectedIndex;
       
       
       document.getElementById("dropdownlineas").className= index;
   		
    }
});
	</script>
	</body>

</html>
