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
        								Inicio <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span> {{$iteration['name']}} <span class="fc-green"> &raquo; </span> Lista de Comprobación <span class="fc-green"> &raquo; </span> Crear 
        							</div>
                        
        							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif  
                                            
                      <div class="section-title fc-blue-iii fs-big">
        								Crear Lista de Comprobación 
        							</div>

                      <div class="form-content">
                        {{ Form::open(array('action' => array('ChecklistController@create', $project['id'], $iteration['id'] ), 'id' => 'form-create-checklist')) }}				
                          
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Título: <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4">
                              {{ Form::text('values[title]', (isset($values['title']))?$values['title']:'', array('class'=>'form-control app-input')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('title'))?$errors->first('title'):''?></span>  
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Fecha tope <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4  date">
                              {{ Form::text('values[closing_date]',(isset($values['closing_date']))?$values['closing_date']:'', array('type' => 'text', 'class' => 'form-control app-input datepicker', 'id' => 'calendar')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('closing_date'))?$errors->first('closing_date'):''?></span>  
                            </div>
                          </div>                 

                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Seleccione los principios: </label>  
                            <div class="col-md-8">
                              @if (!is_null($checklistItems))
                                @foreach($checklistItems as $checklistItem)

                                  {{Form::checkbox('values[checklistItems][]', $checklistItem['id'], FALSE) }} 
                                  <label> {{ $checklistItem['rule']}} </label> 
                                  <i style="cursor:pointer;" data-container="body" data-toggle="popover" data-placement="right" data-content="{{$checklistItem['description']}}" class="fc-turquoise fa fa-info-circle fa-fw"></i>
                                  <br>

                                @endforeach
                                  <span class="error fc-pink fs-min"><?= ($errors->has('checklistItems'))?'Debe seleccionar un pricipio':''?></span>
                              @endif                              
                            </div>
                          </div> 

                          <div id="{{$sizePrinciples}}" class="principles-content">
                            @if(isset($values['new_principle']))
                              @foreach($values['new_principle'] as $index => $principle)
                              
                              <div class="form-group checklist-principle-{{$index}}">
                                <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Principio</label>
                                <div class="col-md-4">
                                  {{ Form::text('values[new_principle]['.$index.'][rule]', $principle['rule'], array('class'=>'form-control principle-input app-input')) }}
                                  <br><br>
                                  <span class="error fc-pink fs-min hidden">Debe indicar el principio </span>
                                </div>
                              </div>

                              <div class="form-group checklist-principle-{{$index}}">
                                  <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Descripci&oacute;n</label>
                                  <div class="col-md-4">
                                    {{ Form::text('values[new_principle]['.$index.'][description]', $principle['description'], array('class'=>'form-control principle-input app-input')) }}
                                    <br><br>
                                    <span class="error fc-pink fs-min hidden">Debe indicar una descripci&oacute;n del principio</span>
                                  </div>
                              </div>

                              <div class="form-group checklist-principle-{{$index}}">
                                <label class="col-md-4 title-label control-label"></label>
                                <div class="col-md-4">
                                  <div data-principle-id="{{$index}}" class="form-group btn-delete-principle-alert circle activity-option txt-center fs-big fc-pink pull-right">
                                    <i class="fa fa-times fa-fw"></i>
                                  </div>
                                </div>
                              </div>

                            @endforeach
                          @endif
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">&nbsp;</label>  
                            <div class="col-md-4">
                              <div data-principle-id="{{ isset($values['new_principle']) ? count($values['new_principle']) : 0}}" class="btn-add-principle" style="cursor:pointer;">
                                <div class="circle activity-option txt-center fs-big fc-turquoise">
                                  <i class="fa fa-plus fa-fw"></i>
                                </div>
                              </div>
                              <span class="fs-min">Hacer clic para agregar un principio a la lista de comprobaci&oacute;n<i style="cursor:pointer;" data-container="body" data-toggle="popover" data-placement="right" data-content="Puede agregar nuevos pricipios si lo desea" class="fc-turquoise fa fa-info-circle fa-fw"></i></span> 
                            </div> 
                          </div>      
                          <div class="form-group">
                               <div class="col-md-4 btn-save-dashboard common-btn btn-ii btn-green txt-center btn-create-checklist">Crear</div> 
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
  <script type="text/javascript">

    $(document).ready(function() {
        $('#calendar').datepicker({
        format: 'dd-mm-yyyy',
        language: 'es',
        startDate: '0d',      
        daysOfWeekDisabled: [0,6]  
        });
    });

  </script>

	</body>

</html>
