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
								Inicio 
							</div>								

							<div>

		                	<span> Desarrolladores</span>
		                	<i class="fc-green fa-venus">Sandra Jim&eacute;nez</i>	
		                	<i class="fc-green fa-mars">Aldemaro D&iacute;az</i>	
		                	<i class="fc-green fa-venus">Mar&iacute;a F Malav&eacute;</i>	


		                	</div>	

		                	<div>
		                	<span> Librer&iacute;as utilizadas</span>

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

      	var projectId = $(this).data('projectId'),
      		iterationId = $(this).data('iterationId'); 

      	 window.location.href = projectURL+'/proyecto/detalle/'+projectId+'/'+iterationId;

      })

  	});
	</script>
	</body>

</html>
