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
        								Inicio <span class="fc-green"> &raquo; </span> {{$project['name']}} <span class="fc-green"> &raquo; </span>Tormenta de Ideas<span class="fc-green"> &raquo; </span> Editar
        							</div>
                                             
        							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="{{URL::action('StormIdeasController@index', array($project['id']))}}" class="btn-back"> Volver</a>

                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif   

                      @if (Session::has('error_message'))
                        <div class="error-alert-dashboard"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{Session::get('error_message')}}</div>
                      @endif 
                                            
                      <div class="section-title fc-blue-iii fs-big">
        								Editar Tormenta de Ideas
        							</div>

                      <div class="form-content">
                        {{ Form::open(array('action' => array('StormIdeasController@edit', $values['id'] ), 'id' => 'form-edit-storm-ideas')) }}				
                          
                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Nombre: <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-4">
                              {{ Form::text('values[name]', (isset($values['name']))?$values['name']:'', array('class'=>'form-control app-input')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('name'))?$errors->first('name'):''?></span>  
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-md-4 title-label fc-grey-iv control-label" for="textinput">Ideas <span class="fc-pink fs-med">*</span></label>  
                            <div class="col-md-6">
                              {{ Form::textarea('values[ideas]', (isset($values['ideas']))?$values['ideas']:'', array('class'=>'form-control app-input', 'rows' => '12')) }}
                              <label class="error fc-pink fs-min" style="display:none;"></label>
                              <span class="error fc-pink fs-min"><?= ($errors->has('ideas'))?$errors->first('ideas'):''?></span>  
                            </div>
                          </div>

                          <div class="form-group">
                               <div class="col-md-4 btn-save-dashboard common-btn btn-ii btn-yellow txt-center btn-edit-storm-ideas">Editar</div> 
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
