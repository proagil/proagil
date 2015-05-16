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
        								Inicio <span class="fc-green"> &raquo; </span> {{$projectName}}  <span class="fc-green"> &raquo; </span> Crear iteraci&oacute;n
        							</div>
                   
        							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif      

                    <div class="error-alert-dashboard error-alert hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> <span class="error-text"> Verifique los campos obligatorios</span></div>                      
                      
                      <div class="section-title fc-blue-iii fs-big">
        								Crear iteraci&oacute;n
        							</div>           

                      <div class="form-content">
                        {{ Form::open(array('action' => array('IterationController@create'), 'id' => 'form-create-iteration')) }}	   <input name="values[project_id]" value="{{$projectId}}" type="hidden">                                             
                          <div class="iterations-content">
                               <div class="iteration-inputs iteration-'+iterationsCount+'">                           
                                  <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">N&uacute;mero de iteraci&oacute;n <span class="fc-pink fs-med">*</span></label>
                                  <div class="col-md-4">
                                    <input  placeholder="Ej.: 1" style="width: 80px;" class="iteration-number form-control app-input app-input-ii" name="values[order]" type="number">                         
                                  </div>
                                </div>                               
                                <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Nombre de iteraci&oacute;n <span class="fc-pink fs-med">*</span></label>  
                                  <div class="col-md-4">
                                    <input placeholder="Ej.: Pruebas" class="form-control app-input app-input-ii" name="values[name]" type="text">                        
                                  </div>
                                </div>                         
                                <div class="form-group">
                                  '<label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Artefactos a utilizar</label>  
                                  '<div class="col-md-4">
                                    @if(!empty($artefacts))
                                      @foreach($artefacts as $artefact)
                                          <input name="values[artefacts][]" type="checkbox" value="{{$artefact->id}}">
                                          <label>{{$artefact->name}}</label>
                                          <i style="cursor:pointer;" data-artefact-id="{{$artefact->id}}" class="btn-artefact-description fc-turquoise fa fa-info-circle fa-fw"></i>
                                          <br>
                                       @endforeach                           
                                    @endif                            
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label " for="textinput">Fecha inicio<span class="fc-pink fs-med">*</span></label>  
                                  <div class="col-md-4">
                                    <input data-input-type="date" class="form-control app-input app-input-ii input-date" name="values[init_date]" type="text" value="">                           
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Fecha fin<span class="fc-pink fs-med">*</span></label>  
                                  <div class="col-md-4">
                                    <input data-input-type="date" class="form-control app-input app-input-ii input-date" name="values[end_date]" type="text" value=""> 
                                    </br>
                                    </br>
                                    <label class="error fc-pink fs-min" style="display:none;"></label>
                                    <span class="error fc-pink fs-min"><?= ($errors->has('end_date'))?$errors->first('end_date'):''?></span> 
                                  </div>
                                </div> 

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

                            <div class="btn-create-iteration txt-center fs-med common-btn btn-iii btn-green pull-right txt-center">
                              Guardar iteraci&oacute;n
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

       <!-- INIT MODAL: artefact description -->
      <div class="modal fade" id="artefact-description-modal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="border-radius:0px;">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="fs-med fa fa-times fc-pink fa-fw"></i></button>
                      <div class="fs-med text-center f-bold fc-turquoise artefact-name-i" ></div>
                    </div>
                    <div class="modal-body">
                      <div class="form-group-modal">
                        <label  class=" control-label">Descripci&oacute;n</label>
                        <div class="artefact-description">
                        
                          </div>
                        </div>
                    </div>
              </div>
            </div>
        </div>
        <!-- END MODAL: artefact description -->  

  <script type="text/javascript">

  var userRoles = <?= json_encode($roles) ?>; 

  </script>   


	@include('frontend.includes.javascript')

	</body>

</html>
