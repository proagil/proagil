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
        								Inicio <span class="fc-green"> &raquo; </span> {{$project['name']}}  <span class="fc-green"> &raquo; </span> {{$iteration['name']}} <span class="fc-green"> &raquo; </span> Verificar Lista de Comprobación
        							</div>
                      
        							<i class="fc-green glyphicon glyphicon-chevron-left"></i> <a href="#" class="btn-back"> Volver</a>
                      
                      @if (Session::has('success_message'))
                        <div class="success-alert"><i class="fc-grey-i glyphicon glyphicon-alert"></i> {{Session::get('success_message')}} </div>
                      @endif 

                      @if(isset($error_message))
                        <div class="error-alert-dashboard"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> {{$error_message}}</div>
                      @endif 

                      <div class="section-title fc-blue-iii fs-big">
        								Verificar Lista de Comprobación 
        							</div>
                      
                      <label class="error fc-pink fs-min hidden"></label>

                      <div class="form-content">
                        {{ Form::open(array('action' => array('ChecklistController@verify', $checklist['id'] ), 'id' => 'form-verify-checklist')) }}				
                          
                          <div class="form-group">
                            <div class="col-md-12">
                              <p class="text-center fc-turquoise f-bold fs-big text-uppercase">{{$checklist['title']}}</p>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <p class="text-center fs-med">
                                A continuación, se presentan una serie de principios, por favor indique si su aplicación cumple o no con cada uno de ellos. 
                              </p>
                            </div>
                          </div>                          

                          <div class="form-group">
                            <div class="col-md-8 col-md-push-2">
                                </br>
                                @foreach($checklistItems as $checklistItem)

                                <div class="form-group">
                                  
                                  <div class="fs-med" >
                                      <i class="fs-med fa fa-bullseye fc-turquoise fa-fw f-bold"></i>
                                      {{$checklistItem['rule']}}
                                      <span class="fc-pink">*</span>
                                      <i style="cursor:pointer;" data-container="body" data-toggle="popover" data-placement="right" data-content="{{$checklistItem['description']}}" class="fc-turquoise fa fa-info-circle fa-fw"></i>
                                  </div>
                                  <div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{Form::radio('values['.$checklistItem['id'].']', Config::get('constant.checklist.item.satisfy'),(isset($values[$checklistItem['id']]))&&($values[$checklistItem['id']]==1)?TRUE:FALSE)}} 
                                    <label class="checklist-option">Sí</label> 
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    {{Form::radio('values['.$checklistItem['id'].']', Config::get('constant.checklist.item.not_satisfy'),(isset($values[$checklistItem['id']]))&&($values[$checklistItem['id']]==2)?TRUE:FALSE)}} 
                                    <label class="checklist-option">No</label>
                                  </div>
                                </div> 
                                @endforeach
                            </div>
                          </div> 

                          <div class="form-group">
                               <div class=" col-md-8 col-md-push-3 common-btn f-bold btn-save-dashboard btn-ii btn-green txt-center btn-verify-checklist">Verificar</div> 
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
