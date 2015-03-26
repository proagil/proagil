<?php

class PublicProbeController extends BaseController {

	public function show($probeUrl){

		$probe = Probe::getProbeTemplate($probeUrl); 

		return View::make('frontend.probe.show')
					 ->with('probeId', $probe['id'])
					 ->with('probeUrl', $probeUrl)
					 ->with('probe', $probe); 

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

	        			$responseOptions = array(
	        				'probe_template_option_id'		=> $option,
	        				'probe_template_element_id'		=> $elementId
	        			);

	        			Probe::saveResponse($responseOptions); 

	        		}

	        	}

	        	if($elementType=='radio') {

        			$responseOptions = array(
        				'probe_template_option_id'		=> $value,
        				'probe_template_element_id'		=> $elementId,
        			);

        			Probe::saveResponse($responseOptions); 	        		

	        	}

	        	if($elementType=='text') {

        			$responseOptions = array(
        				'value'							=> $value, 
        				'probe_template_element_id'		=> $elementId
        			);

        			Probe::saveResponse($responseOptions); 	        		

	        	}

	        	if($elementType=='textarea') {

        			$responseOptions = array(
        				'value'							=> $value, 
        				'probe_template_element_id'		=> $elementId
        			);

        			Probe::saveResponse($responseOptions); 	       	        		

	        	}
	        }

	        return Redirect::to(URL::action('PublicProbeController@send', array($probeUrl)));

		}else{

			return Redirect::to(URL::action('PublicProbeController@show', array($probeUrl)));

		}

	}

	public function send($probeUrl){
		return View::make('frontend.probe.send'); 
	}

}
