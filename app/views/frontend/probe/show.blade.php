<html>

	@include('frontend.includes.head')

	<body>
	    <div class="container">
	        <div class="row show-probe-container">
	            <div class="col-md-8 col-lg-8">

	            	@if ($probe['status']==2)
	                <div class="show-probe-panel panel panel-default">
	                    <div class="panel-body">
	                    	  <div class="login-title txt-center fs-big">
	                    	  		Sondeo <br>
	                    	  		<span class="fc-turquoise f-bold fs-med">{{$probe['title']}}</span>                 	  		
	                    	  </div>	 

                        	  <label class="show-probe-description f-bold fc-blue-ii">{{$probe['description']}}</label> <br>

                        	  <label class="show-probe-description f-bold fc-pink">Obligatorio (*)</label> 

                     			<div class="error-alert hidden"><i class="fc-blue-iii glyphicon glyphicon-alert"></i> Verifique los campos obligatorios</div>
                       	  

                        	  {{ Form::open(array('action' => array('PublicProbeController@save', $probeUrl), 'id' => 'form-save-probe-results')) }}

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

		   									{{Form::checkbox('values[probe_checkbox_'.$element['id'].'][]', $option['id'], FALSE) }} 
		                                  	<label class="probe-option"> {{$option['name']}}</label> <br>	                            	

		                            	@endforeach
		                            	<label class="error fc-pink fs-min" style="display:none"></label>
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

		   									{{Form::radio('values[probe_radio_'.$element['id'].']', $option['id'], FALSE) }} 
		                                  	<label class="probe-option"> {{$option['name']}}</label> <br>	                            	
		                            	@endforeach
		                            	<label class="error fc-pink fs-min" style="display:none"></label>
		                            </div>                          	  	

                        	  	@endif 

                        	  	@if($element['form_element']==Config::get('constant.probe.element.input'))

		                            <div class="form-group">
		                            	<label class="probe-question-title fc-blue-ii">{{$element['question']}}
		                            		@if($element['required'])
		                            	 		<span class="fc-pink">*</span> 
		                            	 	@endif
		                            	 </label>

		                                {{ Form::text('values[probe_text_'.$element['id'].']', (isset($values['first_name']))?$values['first_name']:'', array('class' => 'app-input app-input-i form-control'))}} 
		                                <label class="error fc-pink fs-min" style="display:none"></label>

		                            </div>                         	  	

                        	  	@endif

                        	  	@if($element['form_element']==Config::get('constant.probe.element.textarea'))

		                            <div class="form-group">
		                            	<label class="probe-question-title fc-blue-ii">{{$element['question']}}
		                            		@if($element['required'])
		                            	 		<span class="fc-pink">*</span> 
		                            	 	@endif
		                            	 </label>

		                                {{ Form::textarea('values[probe_textarea_'.$element['id'].']', (isset($values['first_name']))?$values['first_name']:'', array('class' => 'app-input app-input-i form-control', 'rows' => '3'))}} 
		                               <label class="error fc-pink fs-min" style="display:none"></label>

		                            </div>                         	  	

                        	  	@endif                          	  	                         	  	                       

                        	  @endforeach                                                       

	                             <div class="btn-content">		                                    		                                                                
	                            	<div class="btn-send-public-probe common-btn btn-ii btn-turquoise txt-center btn-register">Enviar</div>
	                            </div>
                        {{Form::close()}} 
	                    </div>
	                </div>
	                @else
	                <div class="show-probe-panel panel panel-default">
	                    <div class="panel-body">
	                    	  <div class="login-title txt-center fs-big">
								El sondeo que solicita se encuentra cerrado. Si necesita m&aacute;s informaci&oacute;n p&oacute;ngase en contacto con su autor. Gracias        	  		
	                    	  </div>
	                   	</div>
	                </div>
	                @endif
	                <div class="brand-img pull-right">
	                	 <span class="login-title txt-center fs-min"> Sondeo generado con: 
							<img  style="width:10%" src="{{URL::to('/').'/images/logo-sm.png'}}"/>
	                	 </span>
	                	 
	                </div>	                
	            </div>
	        </div>
	    </div>	

		@include('frontend.includes.javascript')

		{{ HTML::script('js/frontend/jquery.validate.min.js') }}

		<script>

   		 $(function() {

   		 	 var probeElements = <?= json_encode($probe['elements']) ?>,
   		 	 	 rulesName = [],
   		 	 	 rulesValue = [],
   		 	 	 rulesArray,
   		 	 	 elementName = '';  

   		 	 // create array rules for probe elements
   		 	 $.each(probeElements, function(index, element) {
   		 	 	if(element.required){
	   		 	 	if(element.form_element == <?= Config::get('constant.probe.element.radio') ?>) {

	   		 	 		elementName = 'values[probe_radio_'+element.id+']'; 

	   		 	 		rulesName.push(elementName);
	   		 	 		rulesValue.push('required'); 
	   		 	 		 
	   		 	 	} 
	   		 	 	if(element.form_element == <?= Config::get('constant.probe.element.checkbox') ?>) {

	   		 	 		elementName = 'values[probe_checkbox_'+element.id+'][]'; 

	   		 	 		rulesName.push(elementName);
	   		 	 		rulesValue.push('required'); 
	   		 	 		 
	   		 	 	}  
	   		 	 	if(element.form_element == <?= Config::get('constant.probe.element.input') ?>) {

	   		 	 		elementName = 'values[probe_text_'+element.id+']'; 

	   		 	 		rulesName.push(elementName);
	   		 	 		rulesValue.push('required'); 
	   		 	 		 
	   		 	 	}  
	   		 	 	if(element.form_element == <?= Config::get('constant.probe.element.textarea') ?>) {

	   		 	 		elementName = 'values[probe_textarea_'+element.id+']';

	   		 	 		rulesName.push(elementName);
	   		 	 		rulesValue.push('required'); 
	   		 	 		 
	   		 	 	}  	   		 	 		   		 	 		   		 	 	  		 	 		
   		 	 	}

   		 	 }); 

   		 	 rulesArray =_.object(rulesName,rulesValue); 


	  		$('#form-save-probe-results').validate({
	  			errorClass: 'error-input',
				rules: rulesArray,
				errorPlacement: function(error,element) {
    				return true;
 				},
 				invalidHandler: function(event, validator){

 					$('.error-alert').removeClass('hidden'); 

 				}
			}); 		 	 

   		 });
    
		</script>

	</body>

</html>