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
        								Inicio <span class="fc-green"> &raquo; </span> Proyecto <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span> Configurar categor&iacute;as
        							</div>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif 

                      <i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>   

        							<div class="section-title fc-blue-iii fs-big">
        								Configurar categor&iacute;as
        							</div>

                      <div class="form-content">
                        {{ Form::open(array('action' => array('ActivityCategoryController@edit', $projectId), 'id' => 'form-edit-categories')) }}							
                         
                          <div class="categories-content">
                            @if (isset($categories))
                               @foreach($categories as $index => $category)
                              <div class="form-group project-saved-category-{{$category->id}}">
                                <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Categor&iacute;a </label>  
                                <div class="col-md-4">
                                    {{ Form::text('values[category]['.$category->id. ']', $category->name, array('placeholder' => 'Ej: Requisitos', 'class'=>'form-control category-input app-input')) }}
                                    <div data-category-id="{{$category->id}}" data-category-name="{{$category->name}}" data-project-id="{{$projectId}}" class="btn-delete-saved-invitation circle activity-option txt-center fs-big fc-turquoise">
                                      <i class="fa fa-times fa-fw"></i>
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
                              <span class="fc-turquoise fs-min">Hacer clic para agregar categor&iacute;a de actividades<i style="cursor:pointer;" data-container="body" data-toggle="popover" data-placement="top" data-content="Las categor&iacute;as le permiten clasificar las actividades de su proyecto" class="fc-turquoise fa fa-info-circle fa-fw"></i></span> 

                            </div> 
                          </div>   

                          <div class="form-group">
                               <div class="col-md-4 btn-save-dashboard common-btn btn-ii btn-turquoise txt-center btn-edit-categories">Guardar</div> 
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
