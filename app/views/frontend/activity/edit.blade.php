<!DOCTYPE html>
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
								Inicio <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span> Editar Actividad
							</div>
							@if (Session::has('success_message'))
                        		<div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      		@endif 
                      		<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>                         
        							
                      		<div class="section-title fc-blue-iii fs-big">Editar Actividad </div>

                       		<div class="form-content">
	                        {{ Form::open(array('action' => array('ActivityController@edit', $activityId), 'id' => 'form-edit-activity')) }}							
								                       

	                         	<div class="form-group">
	                            	<label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">T&iacute;tulo</label>  
	                            <div class="col-md-4">
	                              {{ Form::text('values[title]', (isset($values['title']))?$values['title']:'', array('class'=>'form-control app-input')) }}

	                              <label class="error fc-pink fs-min" style="display:none;"></label>
	                              <span class="error fc-pink fs-min"><?= ($errors->has('title'))?$errors->first('title'):''?></span>  
	                            </div>
	                          </div>

	                          <div class="form-group">
	                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Descripci&oacute;n</label>  
	                            <div class="col-md-4">
	                              {{ Form::textarea('values[description]', (isset($values['description']))?$values['description']:'', array('class'=>'form-control app-input', 'rows' => '3')) }}
	                              <label class="error fc-pink fs-min" style="display:none;"></label>
	                              <span class="error fc-pink fs-min"><?= ($errors->has('description'))?$errors->first('description'):''?></span>  
	                            </div>
	                          </div>

	                          @if (!empty($categories))
	                          <div class="form-group">
	                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Categor&iacute;a</label>  
	                            <div class="col-md-4">
	                              {{ Form::select('values[category_id]', $categories, (isset($values['category_id']))?$values['category_id']:'' , array('class'=>'form-control app-input')) }}
	                              <label class="error fc-pink fs-min" style="display:none;"></label>
	                              <span class="error fc-pink fs-min"><?= ($errors->has('category_id'))?$errors->first('category_id'):''?></span>  
	                            </div>
	                          </div>
	                          @endif
	                          
	                          <div class="form-group">
	                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Asignar actividad</label>  
	                            <div class="col-md-4">
	                              {{ Form::select('values[assigned_user_id]', $usersOnProject, (isset($values['user_id']))?$values['user_id']:'' , array('class'=>'form-control app-input')) }}
	                              <label class="error fc-pink fs-min" style="display:none;"></label>
	                              <span class="error fc-pink fs-min"><?= ($errors->has('assigned_user_id'))?$errors->first('assigned_user_id'):''?></span>  
	                            </div>
	                          </div>

	                          <div class="form-group">
	                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Fecha tope</label>  
	                            <div class="col-md-4  date">
	                            {{ Form::text('values[closing_date]',(isset($values['closing_date']))?$values['closing_date']:'', array('type' => 'text', 'class' => 'form-control app-input datepicker', 'id' => 'calendar')) }}
	                              <label class="error fc-pink fs-min" style="display:none;"></label>
	                              <span class="error fc-pink fs-min"><?= ($errors->has('closing_date'))?$errors->first('closing_date'):''?></span>  
	                            </div>
	                          </div> 

	                          <div class="form-group">
	                               <div class="col-md-4 btn-save-dashboard common-btn btn-ii btn-turquoise txt-center btn-edit-activity">Guardar</div> 
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
					startDate: '0d'		
			    });
			});

		</script>

	</body>

</html>
