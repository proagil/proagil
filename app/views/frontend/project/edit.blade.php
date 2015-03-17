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
        								Inicio <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span> Editar 
        							</div>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif   

                      <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>                       
        							
                      <div class="section-title fc-blue-iii fs-big">
        								Editar Proyecto
        							</div>

                      <div class="form-content">
						          {{ Form::open(array('action' => array('ProjectController@edit', $projectId), 'id' => 'form-edit-project'))}}
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label">Nombre</label>  
                            <div class="col-md-4">
                              {{ Form::text('values[name]', (isset($values['name']))?$values['name']:'', array('class'=>'form-control app-input')) }}

                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('name'))?$errors->first('name'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label">Descripci&oacute;n</label>  
                            <div class="col-md-4">
                              {{ Form::textarea('values[description]', (isset($values['description']))?$values['description']:'', array('class'=>'form-control app-input', 'rows' => '3')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('description'))?$errors->first('description'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label">Tipo de proyecto</label>  
                            <div class="col-md-4">

                              {{ Form::select('values[project_type]', $projectTypes, (isset($values['project_type_id']))?$values['project_type_id']:'' , array('class'=>'form-control app-input')) }}
                              
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('project_type'))?$errors->first('project_type'):''?></span>  
                            </div>
                          </div> 
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label">Artefactos del proyecto</label>  
                            <div class="col-md-4">
                              @if (!is_null($artefacts))
                                @foreach($artefacts as $artefact)

                                  {{Form::checkbox('values[artefacts][]', $artefact->id, (in_array($artefact->id, $projectArtefacts))?TRUE:FALSE) }} 
                                  <label> {{ $artefact->name }} </label> <br>

                                @endforeach
                              @endif                              
                            </div>
                          </div> 
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput"><i class="fs-med fa fa-times fc-pink fa-fw"></i> <a href="#" class="txt-undrln btn-delete-project" data-project-id="{{$projectId}}"> Eliminar proyecto</a></label>  
                          </div>                                                                              

                          <div class="form-group">
                               <div class="col-md-4 btn-save-dashboard common-btn btn-ii btn-turquoise txt-center btn-edit-project">Guardar</div> 
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