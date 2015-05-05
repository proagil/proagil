<!DOCTYPE html>
<html>

	@include('frontend.includes.head')

	<body>

	    <div id="wrapper">

	    	@include('frontend.includes.header')

	        <div id="page-wrapper">
	            <div class="row">
	                <div class="col-lg-12">
        						<div class="section-content">
        							<div class="breadcrumbs-content">
        								Inicio <span class="fc-green"> &raquo; </span> Editar iteraci&oacute;n
        							</div>
                   
        							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif      

                    <div class="error-alert-dashboard error-alert hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> <span class="error-text"> Verifique los campos obligatorios</span></div>                      
                      
                      <div class="section-title fc-blue-iii fs-big">
        								Editar iteraci&oacute;n
        							</div>           

                      <div class="form-content">
                        {{ Form::open(array('action' => array('IterationController@edit', $iterationId), 'id' => 'form-edit-iteration')) }}	

                      <div class="question-number  text-center f-bold fs-fmed text-uppercase"> <i class="fs-big fc-green fa fa-rotate-right fa-fw"></i> Iteraciones </div>                                                 

                          <div class="iterations-content">
                          </div> 

                          <div class="probe-general-buttons">

                            <div class="btn-create-project txt-center fs-med common-btn btn-iii btn-green pull-right txt-center">
                              Guardar iteraci&pacute; 
                            </div>                            
                          </div>
                         
                          {{Form::close()}}
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

	</body>

</html>
