<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')

			<!-- compartir modal -->
		<div id="myModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header" style="padding:35px 50px;">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Enviar prototipo</h4>
		      </div>
		      <div class="modal-body" style="padding:40px 50px;">
		        {{ Form::open(array('action' => array('PrototypeController@send_prototype'), 'id'  => 'form-create-prototipo')) }}	

					<label>Eligue a quién(es) deseas enviar el prototipo</label>
					<div class ="colaboradores"></div>

					<input class="hidden" name="projectName"   value ="{{$projectName}}" >
					<input class="hidden" name="iterationName" value ="{{$iteration['name']}}" >
					<input class="hidden" name="PrototypeName" value ="{{$PrototypeName}}" >
					<input class="hidden" name="projectId" value ="{{$projectId}}" >
					<input class="hidden" name="iterationId" value ="{{$iterationId}}" >
					<input class="hidden" name="PrototypeId" value ="{{$PrototypeId}}" >

				
					
					<label>Mensaje</label><br>
					<textarea name="mensaje"></textarea>
								
				
		      </div>
		      <div class="modal-footer">
		      	{{ Form::submit('Enviar', array('class' => 'btn btn-success btn-default')) }}
		        <button type="button" class="btn btn-danger btn-default pull-left" data-dismiss="modal">Cancelar</button>
		      </div>
		      {{Form::close()}}
		    </div>

		  </div>
		</div>	
			


	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
						<div class="activities-content">
							<div class="breadcrumbs-content">
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span>  {{$iteration['name']}}  <span class="fc-green"> &raquo; </span> Prototipo
							</div>	

							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="{{URL::action('ProjectController@detail', array($projectId, $iteration['id']))}}" class="btn-back"> Volver</a>													

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif	


		                	@if (Session::has('error_message'))
		                		<div class="error-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('error_message')}} </div>
		                	@endif	
							
							<div class="filters-content">
								<div class="section-title fc-blue-iii fs-big">
									Prototipos
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class="txt-center fs-med common-btn btn-i btn-green pull-right">
								<a href="{{URL::action('PrototypeController@create', array($projectId, $iteration['id']))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear prototipo</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($Prototype_d))
									@foreach($Prototype_d as $prototipo)
									<a href="#" data-toggle="modal" data-target="#imageModal-{{$prototipo['id']}}" >
										<div style="width:{{($projectOwner)?'81%':'96%'}}" class="use-case-item-content">
											<i class="fc-turquoise fa fa-circle-o fa-fw"></i>
											<span> {{$prototipo['title']}}</span>		
										</div>
									</a>	
									@if($projectOwner)	
									<div class="probe-options txt-center">
																	
										<div data-toggle="tooltip" data-placement="top" title="Editar" class=" edit-prototipo circle activity-option txt-center fs-big " id='identificado'data-prototipo-id="{{$PrototypeId}}" >
											<a href="{{URL::action('PrototypeController@showdiagram', array($prototipo['id'], $projectId, $iterationId))}}">
												<i class="fa fa-pencil fc-yellow fa-fw"></i>
											</a>
										</div>
										<div  data-iter="{{$iterationId}}"  title= "Enviar" data-usecase-url="{{$prototipo['url']}}" class="send-prototipo circle activity-option txt-center fs-big fc-green">
											<i class="fa fa-envelope fc-green fa-fw"></i>
										</div>							
										<div data-proto-title="{{$prototipo['title']}}" data-prototipo-id="{{$prototipo['id']}}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="delete-prototipo circle activity-option txt-center fs-big ">
											<i class="fa fa-times fc-pink fa-fw"></i>
										</div>																				
									</div>
									@endif									
									@endforeach
								@else
									<div class="txt-center fs-med"> <i class="fa  fa-frown-o fc-yellow fa-fw"></i> No hay prototipos creados</div>
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

	

	<script>

    $(function() {

      $('.project-item').on('click', function(){

      	projectId = $(this).data('projectId');

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId;

      })

  	});

  	 $('.delete-prototipo').on('click', function(){

      		var prototipoId = $(this).data('prototipoId'),
      			prototipoTitle = $(this).data('protoTitle');

          var showAlert = swal({
            title: 'Eliminar Prototipo: '+prototipoTitle,
            text: 'Al eliminar el prototipo se elimina toda su información asociada. ¿Realmente desea eliminarlo?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              window.location.href = projectURL+'//prototipo/eliminar/'+prototipoId;

          });               

      })

  	 $('.send-prototipo').on('click', function(){

  	 	 var iterId = $(this).data('iter'); 
	     $.ajax({
	          url: projectURL+'/prototipo/obtener-info-iteracion/'+iterId,
	          type:'GET',
	          dataType: 'JSON',
	          success:function (response) {

	          	
	              if(!response.error){

	              	var tam=Object.keys(response).length;
	              
	             
	              	for (i=0; i<tam; i++){

	              	$('<input  type= "checkbox"  name="email['+response.data[i].email+']" value="'+response.data[i].email+'"><label>'+response.data[i].email+'</label><br>').appendTo('.colaboradores');

	            
	              	}
	              	

	              }
	          },
	          error: function(xhr, error) {

	          }
	      });      
        $("#myModal").modal();
    });

	</script>
	</body>

</html>
