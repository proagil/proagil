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

		                	<div class="section-title ">

								<div  style="font-size: 100%; font-weight: bold; text-align: center;">Desarrolladores</div>
							</div>
							<div >
								<i style= "height:100px; width:100px;" class="fc-green fa fa-venus"></i> <p> Sandra Jim&eacute;nez </p>
							</div>
		                	
							<div>
							<i class="fc-green fa-mars"></i> <p>Aldemaro D&iacute;az</p>		
							</div>
		                	
		                	<div>
		                	<i class="fc-green fa-venus"></i>Mar&iacute;a F Malav&eacute;</p>		
		                	</div>


		                	</div>	

		                	<div>
		                	<div class="section-title">

								<div  style="font-size: 100%; font-weight: bold; text-align: center;">Librer&iacute;a</div>
							</div>
		                	
		                		<a href="www.jointjs.com">JointJS</a>	

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
