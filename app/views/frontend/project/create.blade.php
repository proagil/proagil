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
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Descripci&oacute;n <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4">
                              {{ Form::textarea('values[description]', (isset($values['description']))?$values['description']:'', array('class'=>'form-control app-input', 'rows' => '3')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('description'))?$errors->first('description'):''?></span>  
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Tipo de proyecto <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4">
                              {{ Form::select('values[project_type]', $projectTypes, (isset($values['project_type']))?$values['project_type']:'' , array('class'=>'form-control app-input')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('project_type'))?$errors->first('project_type'):''?></span>  
                            </div>
                          </div> 
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Artefacto a incluir</label>  
                            <div class="col-md-4">
                              @if (!is_null($artefacts))
                                @foreach($artefacts as $artefact)

                                  {{Form::checkbox('values[artefacts][]', $artefact->id, FALSE) }} 
                                  <label> {{ $artefact->name }} </label> 
                                  <i style="cursor:pointer;" data-container="body" data-toggle="popover" data-placement="right" data-content="{{$artefact->description}}" class="fc-turquoise fa fa-info-circle fa-fw"></i>
                                  <br>

                                @endforeach
                              @endif                              
                            </div>
                          </div> 
                          <div class="categories-content">
                            @if (isset($values['new_category']))
                               @foreach($values['new_category'] as $index => $category)
                              <div class="form-group project-category-{{$index}}">
                                <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Categor&iacute;a </label>  
                                <div class="col-md-4">
                                    {{ Form::text('values[new_category][]', $category, array('placeholder' => 'Ej: Requisitos', 'class'=>'form-control category-input app-input')) }}
                                    <div data-category-id="{{$index}}" class="btn-delete-category circle activity-option txt-center fs-big fc-turquoise">
                                      <i class="fa fa-minus fa-fw"></i>
                                    </div> 
                                    <br><br>
                                    <span class="hidden error fc-pink fs-min">Debe indicar un nombre de categor&iacute;a </span>                          
                                </div>
                              </div>
                              @endforeach
                            @endif
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">&nbsp;</label>  
                            <div class="col-md-4">
                              <div class="btn-add-category" style="cursor:pointer;">
                                <div class="circle activity-option txt-center fs-big fc-turquoise">
                                  <i class="fa fa-plus fa-fw"></i>
                                </div>
                              </div>
                              <span class="fc-turquoise fs-min">Hacer clic para agregar categor&iacute;a de actividades<i style="cursor:pointer;" data-container="body" data-toggle="popover" data-placement="right" data-content="Las categor&iacute;as le permiten clasificar las actividades de su proyecto" class="fc-turquoise fa fa-info-circle fa-fw"></i></span> 
                            </div> 
                          </div>                                                                                                           

                          <div class="form-group">
                               <div class="col-md-4 btn-save-dashboard common-btn btn-ii btn-turquoise txt-center btn-create-project">Guardar</div> 
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
