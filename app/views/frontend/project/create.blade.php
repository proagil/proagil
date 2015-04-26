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
        								Inicio <span class="fc-green"> &raquo; </span> Crear Proyecto
        							</div>
                   
        							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif       
                      
                      <div class="section-title fc-blue-iii fs-big">
        								Crear Proyecto
        							</div>

                     <div class="question-number text-center f-bold fs-fmed text-uppercase"><i class="fs-big fc-green fa fa-folder-open fa-fw"></i>  Informaci&oacute;n de proyecto </div>                      

                      <div class="form-content">
                        {{ Form::open(array('action' => array('ProjectController@create'), 'id' => 'form-create-project')) }}				
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Nombre <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4">
                              {{ Form::text('values[name]', (isset($values['name']))?$values['name']:'', array('class'=>'form-control app-input')) }}

                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('name'))?$errors->first('name'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Objetivos <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4">
                              {{ Form::textarea('values[description]', (isset($values['description']))?$values['description']:'', array('class'=>'form-control app-input', 'rows' => '3')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('description'))?$errors->first('description'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Cliente <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4">
                              {{ Form::text('values[name]', (isset($values['name']))?$values['name']:'', array('class'=>'form-control app-input')) }}

                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('name'))?$errors->first('name'):''?></span>  
                            </div>
                          </div>   

                      <div class="question-number  text-center f-bold fs-fmed text-uppercase"> <i class="fs-big fc-green fa fa-rotate-right fa-fw"></i> Iteraciones </div>                                                 

                          <div class="iterations-content">
                            <div class="iteration-inputs">
                              <div class="form-group">
                                <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">N&uacute;mero de iteraci&oacute;n</label>  
                                <div class="col-md-4">
                                  <input class="form-control app-input app-input-ii" name="values[name]" type="text" value="">                           
                                </div>
                              </div>                               
                              <div class="form-group">
                                <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Nombre de iteraci&oacute;n</label>  
                                <div class="col-md-4">
                                  <input class="form-control app-input app-input-ii" name="values[name]" type="text" value="">                           
                                </div>
                              </div>                           
                              <div class="form-group">
                                <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Artefactos a utilizar</label>  
                                <div class="col-md-4">
                                  @if (!is_null($artefacts))
                                    @foreach($artefacts as $artefact)

                                      {{Form::checkbox('values[artefacts][]', $artefact->id, FALSE) }} 
                                      <label> {{ $artefact->name }} </label> 
                                      <i style="cursor:pointer;" data-artefact-id="{{$artefact->id}}" class="btn-artefact-description fc-turquoise fa fa-info-circle fa-fw"></i>
                                      <br>

                                    @endforeach
                                  @endif                              
                                </div>
                              </div> 
                              <div class="form-group">
                                <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Fecha inicio</label>  
                                <div class="col-md-4">
                                  <input class="form-control app-input app-input-ii" name="values[name]" type="text" value="">                           
                                </div>
                              </div> 
                              <div class="form-group">
                                <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">Fecha fin</label>  
                                <div class="col-md-4">
                                  <input class="form-control app-input app-input-ii" name="values[name]" type="text" value="">                           
                                </div>
                              </div> 

                              <div class="colaborators-content">
                              </div> 
                                                         
                              <div class="form-group">
                                <label class="col-md-4 subtitle-label fc-grey-iv control-label" for="textinput">&nbsp;</labeL>
                                <div class="col-md-4">
                                  <div class="btn-add-colaborator" style="cursor:pointer;">
                                    <div class="circle activity-option txt-center fs-big fc-turquoise">
                                      <i class="fa fa-plus fa-fw"></i>
                                    </div>
                                  </div>
                                  <span class="fs-min">Hacer clic para agregar colaboradores a la iteraci&oacute;n</span>
                                </div>
                              </div>                               

                            </div>

                          </div> 

                          <div class="probe-general-buttons">

                            <div class="txt-center fs-med common-btn btn-iii btn-green pull-right txt-center">
                              Guardar proyecto
                            </div>                  
                            <div class="fs-med common-btn btn-iii btn-turquoise pull-right txt-center">
                              <a href="#">Agregar iteraci&oacute;n</a>
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

       <!-- INIT MODAL HTML TO REASSIGN ACTIVITY -->
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
        <!-- END MODAL HTML TO REASSIGN ACTIVITY -->   

  <script type="text/javascript">

  var userRoles = <?= json_encode($roles) ?>; 

  </script>          

	@include('frontend.includes.javascript')

	</body>

</html>
