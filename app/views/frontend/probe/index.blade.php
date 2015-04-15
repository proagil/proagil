<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')

			<!-- Social media odal -->
			<div class="modal fade" id="modal-share-probe" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content probe-share-modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="fs-big" aria-hidden="true">&times;</span></button>
			      </div>
			      <div class="modal-body">
			        <a class="share" href="#">share me</a>
			      </div>
			    </div>
			  </div>
			</div>	

			<div style="display:none" class="social-icons-container">
				<i style="color:#3b5998" class="share-option share-probe-facebook fs-xbig fa fa-facebook cur-point fa-fw"></i>
				<i style="color:#55acee" class="share-option share-probe-twitter fs-xbig fa fa-twitter cur-point  fa-fw"></i>
				<i style="color:#2672ae" class="share-option share-probe-linkedin fs-xbig fa fa-linkedin cur-point fa-fw"></i>
			</div>				


	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
						<div class="activities-content">
							<div class="breadcrumbs-content">
								Inicio  <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Sondeos
							</div>	

							 <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>													

		                	@if (Session::has('success_message'))
		                		<div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
		                	@endif	


		                	@if (Session::has('error_message'))
		                		<div class="error-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('error_message')}} </div>
		                	@endif	
							
							<div class="filters-content">
								<div class="section-title fc-blue-iii fs-big">
									Sondeos
									<div class="section-arrow pull-right"></div>
								</div>							

							</div>	
							@if($projectOwner)
							<div class=" fs-med common-btn btn-i btn-green pull-right">
								<a href="{{URL::action('ProbeController@create', array($projectId))}}">  <i class="fs-big fa fa-plus fa-fw"></i> Crear sondeo</a>
							</div>
							@endif
							
							<div class="list-content">
								@if(!empty($probes))
									@foreach($probes as $probe)
									<div class="probe-item-content" {{(!$projectOwner)?'style=width:100%':''}} data-probe-url="{{$probe['url']}}">
										<i class="fc-green fa fa-th-list fa-fw"></i>

											<span class="f-bold"> {{$probe['title']}} </span>		

											@if($probe['status']==1)
												<i class="fc-turquoise fa fa-lock fa-fw"></i> Cerrado
											@else
												<i class="fc-turquoise fa fa-unlock fa-fw"></i> Abierto
											@endif	

											 <i class="fc-turquoise fa fa-comments-o fa-fw"> </i> {{$probe['responses']}}	Respuestas				
									</div>
									@if($projectOwner)	
									<div class="probe-options txt-center">
																	
										<div data-toggle="tooltip" data-placement="top" title="Editar" class="circle activity-option txt-center fs-big ">
											<a href="{{URL::action('ProbeController@edit', array($probe['id']))}}">
												<i class="fa fa-pencil fc-yellow fa-fw"></i>
											</a>
										</div>
										<div data-toggle="tooltip" data-placement="top" title="Resultados" class="circle activity-option txt-center fs-big fc-turquoise">
											<a href="{{URL::action('ProbeController@getProbeResults', array($probe['id']))}}">
												<i class="fa fa-bar-chart-o fa-fw"></i>
											</a>
										</div>
										<div  data-probe-title="{{$probe['title']}}" data-probe-url="{{$probe['url']}}" class="share-probe-popover circle activity-option txt-center fs-big fc-green">
											<i class="fa fa-share-alt fa-fw"></i>
										</div>
																			
										<div data-probe-title="{{$probe['title']}}" data-probe-id="{{$probe['id']}}" data-toggle="tooltip" data-placement="top" title="Eliminar" class="delete-probe circle activity-option txt-center fs-big ">
											<i class="fa fa-times fc-pink fa-fw"></i>
										</div>																				
									</div>
									@endif									
									@endforeach
								@else
									<div class="txt-center fs-med"> <i class="fa  fa-frown-o fc-yellow fa-fw"></i> No hay sondeos creados</div>
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

      $('.probe-item-content').on('click', function(){

      	 probeUrl = $(this).data('probeUrl');

      	 window.location.href = projectURL+'/sondeo/generar/'+probeUrl;

      })

      $('.delete-probe').on('click', function(){

      		var probeId = $(this).data('probeId'),
      			probeTitle = $(this).data('probeTitle');

          var showAlert = swal({
            title: 'Eliminar Sondeo: '+probeTitle,
            text: 'Al eliminar un sondeo se elimina toda su información asociada. ¿Realmente desea eliminarlo?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef6f66',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#ef6f66',
            closeOnConfirm: true
          },
          function(){

              window.location.href = projectURL+'/sondeo/eliminar/'+probeId;

          });               

      })


  	});

      window.fbAsyncInit = function() {
        FB.init({
          appId      : '891076320914205',
          xfbml      : true,
          version    : 'v2.3'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

	</script>
	</body>

</html>
