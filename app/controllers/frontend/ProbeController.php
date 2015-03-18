<?php

class ProbeController extends BaseController {

	public function index($projectId){

	    if(is_null(Session::get('user'))){

	          return Redirect::to(URL::action('DashboardController@index'));

	    }else{

	    	//get user role
	    	 $userRole = Session::get('user_role');

	    	 // get project data
	    	 $project = (array) Project::getName($projectId); 

	    	 $probes = Probe::enumerate($projectId);

	    	return View::make('frontend.probe.index')
	    				->with('projectName', $project['name'])
	    				->with('projectId', $projectId)
	    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
	    				->with('probes', $probes);

	    }

	}

	public function create($projectId){

		// get user role
	    $userRole = Session::get('user_role');

	    if($userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	 $project = (array) Project::getName($projectId); 

	    	 // get answer types
	    	 $types = Probe::getAnswerTypes(); 

	    	return View::make('frontend.probe.create')
	    		    	->with('projectName', $project['name'])
	    		    	->with('answerTypes', $types)
	    				->with('projectId', $projectId); 

	    }else{

	    	 return Redirect::to(URL::action('DashboardController@index'));

	    }
	}

	public function save(){

			// get probe values
		   $values = Input::get('probe');

		   // build probe data
		   $probe = array(
		   		'title'				=> $values ['title'],
		   		'description'		=> $values['description'],
		   		'status'			=> $values['status'],
		   		'url'				=> md5($values['title'].date('H:i:s')),
		   		'project_id'		=> $values['project_id']

		   	);

		   	// get project name
		   $project = (array) Project::getName($values['project_id']);		   

		  // save probe info
		   $probeId = Probe::insert($probe); 

		   if($probeId>0){

		   	// save probe questions
		   	if(isset($values['questions'])){

		   		$questions = $values['questions']; 

		   		foreach($questions as $index => $questionValue){

		   			$question = array( 

		   				'question'			=> $questionValue['question'],
		   				'required'			=> (isset($questionValue['required']))?Config::get('constant.probe.question.required'):Config::get('constant.probe.question.not_required'),
		   				'form_element'		=> $questionValue['form_element'],
		   				'enabled'			=> Config::get('constant.ENABLED'),
		   				'probe_id'			=> $probeId

		   			);

		   			$probeQuestionId = Probe::saveQuestion($question); 

		   			if($probeQuestionId>0){

		   				// save question options (radio buttons and checkboxes)
		   				if(isset($questionValue['option'])){

		   					$questionOptions = $questionValue['option'];

		   					foreach($questionOptions as $optionValue){

			   					$questionOption = array(

			   						'name'							=> $optionValue['name'],
			   						'probe_template_element_id'		=> $probeQuestionId

			   					);

			   					$optionQuestionId = Probe::saveQuestionOption($questionOption); 		   						

		   					}

		   				}
		   			}
		   		}

		   		Session::flash('success_message', 'Se ha creado el Sondeo exitosamente en su proyecto: '.$project['name']); 

                // redirect to index probre view
                return Redirect::to(URL::action('ProbeController@index', array($values['project_id'])));
		   	}

		   }else{

		   		Session::flash('error_message', 'No se ha podido crear el Sondeo en su proyecto: '.$project['name']); 

		   		return Redirect::to(URL::action('ProbeController@index', array($values['project_id'])));

		   }
	}

	public function edit($probeId){

		$probeData = Probe::getProbeElements($probeId); 

		//print_r($probeData ); die; 


		if(!empty($probeData)){

			// get project data
		   	$project = (array) Project::getName($probeData['project_id']);

		   	//probe status
		   	$probeStatus = array(
		   		'1'			=> 'Cerrado',
		   		'2'			=> 'Abierto'
		   	);

	    	 // get answer types
	    	 $answerTypes = Probe::getAnswerTypes(); 	  	 

			return View::make('frontend.probe.edit')
						->with('projectName', $project['name'])
						->with('probeId', $probeId)
						->with('answerTypes', $answerTypes)
						->with('values', $probeData)
						->with('probeStatus', $probeStatus); 			

		}else{

		}

	}

	public function getProbeElement($elementId){

		$element = (array) Probe::getElementData($elementId); 

	    if(!empty($element)){

	      $result = array(
	          'error'   => false,
	          'data'	=> $element
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);		

	}

	public function saveProbeElement() {

		 $values = Input::get('values');

		 $element = array(
		 	'question'			=> $values['question'],
		 	'form_element'		=> $values['form_element'],
		 	'required'			=> $values['required']
		 );

		 if(Probe::updateElement($values['question_id'], $element)){

		 	$element = (array) Probe::getElementData($values['question_id']); 

		      $result = array(
		          'error'   => false,
		          'data'	=> $element
		      );		 	

		 }else{

		      $result = array(
		          'error'     => true
		      );		 	

		 } 

	      header('Content-Type: application/json');
	      return Response::json($result);			 

	}

	public function getProbeOption($optionId) {

		$option = (array) Probe::getOptionData($optionId); 

	    if(!empty($option)){

	      $result = array(
	          'error'   => false,
	          'data'	=> $option
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);		

	}

	public function saveProbeOption() {

		 $values = Input::get('values');

		 $option = array(
		 	'name'			=> $values['name'],
		 );

		 if(Probe::updateOption($values['option_id'], $option)){

		 	$element = (array) Probe::getOptionData($values['option_id']); 

		      $result = array(
		          'error'   => false,
		          'data'	=> $element
		      );		 	

		 }else{

		      $result = array(
		          'error'     => true
		      );		 	

		 } 

	      header('Content-Type: application/json');
	      return Response::json($result);			 

	}		



}
