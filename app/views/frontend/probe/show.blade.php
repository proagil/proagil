<html>

	@include('frontend.includes.head')

	<body>
	    <div class="container">
	        <div class="row show-probe-container">
	            <div class="col-md-8 col-lg-8">

	                <div class="show-probe-panel panel panel-default">
	                    <div class="panel-body">
	                    	  <div class="login-title txt-center fs-big">
	                    	  		Sondeo <br>

	                    	  		<span class="fc-turquoise f-bold fs-med">{{$probe['title']}}</span>                 	  		
	                    	  </div>	 

                        	  <label class="show-probe-description f-bold fc-blue-ii">{{$probe['description']}}</label> 

                        	  {{ Form::open(array('action' => array('PublicProbeController@show', $probeId), 'id' => 'form-save-probe'))}}

                        	  @foreach($probe['elements'] as $element)

                        	  	@if($element['form_element']==Config::get('constant.probe.element.checkbox'))

		                            <div class="form-group">
		                            	<label class="probe-question-title fc-blue-ii"> {{$element['question']}}
		                            		@if($element['required'])
		                            	 		<span class="fc-pink">*</span> 
		                            	 	@endif
		                            	</label>

		                            	<br>	

		                            	@foreach($element['options'] as $option) 

		   									{{Form::checkbox('values[artefacts][]', '', FALSE) }} 
		                                  	<label class="probe-option"> {{$option['name']}}</label> <br>	                            	

		                            	@endforeach
		                            </div>                          	  	

                        	  	@endif

                        	  	@if($element['form_element']==Config::get('constant.probe.element.radio'))

		                            <div class="form-group">
		                            	<label class="probe-question-title fc-blue-ii"> {{$element['question']}}
		                            		@if($element['required'])
		                            	 		<span class="fc-pink">*</span> 
		                            	 	@endif
		                            	</label>

		                            	<br>	

		                            	@foreach($element['options'] as $option) 

		   									{{Form::radio('values[artefacts][]', '', FALSE) }} 
		                                  	<label class="probe-option"> {{$option['name']}}</label> <br>	                            	

		                            	@endforeach
		                            </div>                          	  	

                        	  	@endif 

                        	  	@if($element['form_element']==Config::get('constant.probe.element.input'))

		                            <div class="form-group">
		                            	<label class="probe-question-title fc-blue-ii">{{$element['question']}}
		                            		@if($element['required'])
		                            	 		<span class="fc-pink">*</span> 
		                            	 	@endif
		                            	 </label>

		                                {{ Form::text('values[first_name]', (isset($values['first_name']))?$values['first_name']:'', array('class' => 'app-input app-input-i form-control'))}} 
		                                <label class="error fc-pink fs-min hidden">Esto es un error </label>

		                            </div>                         	  	

                        	  	@endif

                        	  	@if($element['form_element']==Config::get('constant.probe.element.textarea'))

		                            <div class="form-group">
		                            	<label class="probe-question-title fc-blue-ii">{{$element['question']}}
		                            		@if($element['required'])
		                            	 		<span class="fc-pink">*</span> 
		                            	 	@endif
		                            	 </label>

		                                {{ Form::textarea('values[first_name]', (isset($values['first_name']))?$values['first_name']:'', array('class' => 'app-input app-input-i form-control', 'rows' => '3'))}} 
		                                <label class="error fc-pink fs-min hidden">Esto es un error </label>

		                            </div>                         	  	

                        	  	@endif                          	  	                         	  	                       	  	

                        	  @endforeach                                                       

	                             <div class="btn-content">			                                		                                		                                                                
	                            	<div  class="common-btn btn-ii btn-turquoise txt-center btn-register">Enviar</div>
	                            </div>
                        {{Form::close()}} 
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>	

		@include('frontend.includes.javascript')

	</body>

</html>
