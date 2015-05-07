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

                         <input name="values[project_id]" value="{{$projectId}}" type="hidden">
                         <input name="values[iteration_id]" value="{{$iterationId}}" type="hidden">                                             
                          <div class="iterations-content">
                               <div class="iteration-inputs iteration-'+iterationsCount+'">                           
                                  <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">N&uacute;mero de iteraci&oacute;n <span class="fc-pink fs-med">*</span></label>
                                  <div class="col-md-4">
                                    <input value="{{$values['order']}}"  placeholder="Ej.: 1" style="width: 80px;" class="iteration-number form-control app-input app-input-ii" name="values[order]" type="number">                         
                                  </div>
                                </div>                               
                                <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Nombre de iteraci&oacute;n <span class="fc-pink fs-med">*</span></label>  
                                  <div class="col-md-4">
                                    <input value="{{$values['name']}}" placeholder="Ej.: Pruebas" class="form-control app-input app-input-ii" name="values[name]" type="text">                        
                                  </div>
                                </div>                         
                                <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label " for="textinput">Fecha inicio<span class="fc-pink fs-med">*</span></label>  
                                  <div class="col-md-4">
                                    <input value="{{$values['init_date']}}" data-input-type="date" class="form-control app-input app-input-ii input-date" name="values[init_date]" type="text" value="">                           
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Fecha fin<span class="fc-pink fs-med">*</span></label>  
                                  <div class="col-md-4">
                                    <input value="{{$values['end_date']}}" data-input-type="date" class="form-control app-input app-input-ii input-date" name="values[end_date]" type="text" value="">                           
                                  </div>
                                </div> 

                                @if(!empty($colaborators))
                                  @foreach($colaborators as $index => $colaborator)
                                   <div class="form-group">
                                    <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Colaborador {{$index +1}}</label>  
                                    <div class="col-md-4">
                                      <label class="colaborator-label">{{$colaborator['first_name']}} {{$colaborator['last_name']}} - {{$colaborator['email']}}</label>                           
                                    </div>
                                  </div>
                                  @endforeach 
                                @endif
                               

                                <div class="colaborators-content colaborators-content-NEW">
                                </div> 
                                                                    
                                <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">&nbsp;</labeL>
                                  <div class="col-md-4">
                                    <div class="btn-add-new-colaborator" data-iteration-id="NEW" style="cursor:pointer;">
                                      <div class="circle activity-option txt-center fs-big fc-turquoise">
                                        <i class="fa fa-plus fa-fw"></i>
                                      </div>
                                    </div>
                                    <span class="fs-min">Invitar a colaboradores a trabajar en esta iteraci&oacute;n</span>
                                  </div>
                                </div>                             
                              </div>
                          </div> 

                          <div class="probe-general-buttons">

                            <div class="btn-edit-iteration txt-center fs-med common-btn btn-iii btn-green pull-right txt-center">
                              Guardar iteraci&oacute;n
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



  <script type="text/javascript">

  var userRoles = <?= json_encode($roles) ?>; 

  </script>   


	@include('frontend.includes.javascript')

	</body>

</html>
