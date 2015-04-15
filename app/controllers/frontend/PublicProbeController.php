<?php

class PublicProbeController extends BaseController {

	public function show($probeUrl){

		$probe = Probe::getProbeTemplate($probeUrl); 

		if(!empty($probe['elements'])){

			return View::make('frontend.probe.show')
			 ->with('probeId', $probe['id'])
			 ->with('probeUrl', $probeUrl)
			 ->with('probe', $probe); 

		}else{

			return Redirect::to(URL::action('DashboardController@index'));

		}

	}

	public function save($probeUrl) {

		if(Input::has('_token')){

			// get input values
	        $values = Input::get('values');

	        foreach($values as $name => $value) {

	        	$data = explode('_', $name); 

	        	$elementType = $data[1]; 
	        	$elementId = $data[2]; 

	        	if($elementType=='checkbox') {

	        		foreach($value as $option){

	        			if($option!=''){

		        			$responseOptions = array(
		        				'probe_template_option_id'		=> $option,
		        				'probe_template_element_id'		=> $elementId
		        			);

		        			Probe::saveResponse($responseOptions); 

	        			}

	        		}

	        	}

	        	if($elementType=='radio') {

	        		if($value!=''){

	        			$responseOptions = array(
	        				'probe_template_option_id'		=> $value,
	        				'probe_template_element_id'		=> $elementId,
	        			);

	        			Probe::saveResponse($responseOptions); 	 	        			

	        		}       		

	        	}

	        	if($elementType=='text') {

        			if($value!=''){

	        			$responseOptions = array(
	        				'value'							=> $value, 
	        				'probe_template_element_id'		=> $elementId
	        			);

	        			Probe::saveResponse($responseOptions); 	

        			}        		

	        	}

	        	if($elementType=='textarea') {

	        		if($value!=''){

	        			$responseOptions = array(
	        				'value'							=> $value, 
	        				'probe_template_element_id'		=> $elementId
	        			);

	        			Probe::saveResponse($responseOptions); 

	        		}	       	        		

	        	}
	        }

			// get current probe
			$probe = Probe::getProbeByUrl($probeUrl); 

			// update probe response
			Probe::_update($probe['id'], array('responses' => $probe['responses'] + 1 )); 


	        return Redirect::to(URL::action('PublicProbeController@send', array($probeUrl)));

		}else{

			return Redirect::to(URL::action('PublicProbeController@show', array($probeUrl)));

		}

	}

	public function send($probeUrl){
		return View::make('frontend.probe.send'); 
	}

}
