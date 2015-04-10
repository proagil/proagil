<?php

class ProbeController extends BaseController {

	public function __construct(){

	      //not user on session
	      $this->beforeFilter(function(){

	        if(is_null(Session::get('user'))){
	          return Redirect::to(URL::action('LoginController@index'));
	        }

	      });
	 }

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
	    	 $types = Probe::getAnswerTypes(array(Config::get('constant.probe.question.closed'),Config::get('constant.probe.question.open'))); 

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

		if(!empty($probeData)){

			// get project data
		   	$project = (array) Project::getName($probeData['project_id']);

		   	//probe status
		   	$probeStatus = array(
		   		'1'			=> 'Cerrado',
		   		'2'			=> 'Abierto'
		   	);

	    	 // get answer types
	    	 $answerTypesOpen = Probe::getAnswerTypes(array((Config::get('constant.probe.question.open')))); 
	    	 $answerTypesClose = Probe::getAnswerTypes(array((Config::get('constant.probe.question.closed'))));	
	    	 $answerTypes = Probe::getAnswerTypes(array(Config::get('constant.probe.question.closed'),Config::get('constant.probe.question.open')));   	 

			return View::make('frontend.probe.edit')
						->with('projectName', $project['name'])
						->with('probeId', $probeId)
						->with('answerTypesOpen', $answerTypesOpen)
						->with('answerTypesClose', $answerTypesClose)
						->with('answerTypes', $answerTypes)
						->with('values', $probeData)
						->with('probeStatus', $probeStatus); 			

		}else{

		}

	}

	public function saveNewQuestion(){

		// get probe values
		 $values = Input::get('probe');

		   	// save probe questions
		   	if(isset($values['questions'])){

		   		$questions = $values['questions']; 

		   		foreach($questions as $index => $questionValue){

		   			$question = array( 

		   				'question'			=> $questionValue['question'],
		   				'required'			=> (isset($questionValue['required']))?Config::get('constant.probe.question.required'):Config::get('constant.probe.question.not_required'),
		   				'form_element'		=> $questionValue['form_element'],
		   				'enabled'			=> Config::get('constant.ENABLED'),
		   				'probe_id'			=> $values['probe_id']

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

		   		Session::flash('success_message', 'Se ha agregado la pregunta al sondeo'); 

                // redirect to index probre view
                return Redirect::to(URL::action('ProbeController@edit', array($values['probe_id'])));
		   	}

	}

	public function deleteProbe($probeId){

		$values = Probe::getProbeElements($probeId); 

		// delete all probe values for each probe element
		foreach($values['elements'] as $element){

			Probe::deleteQuestion($element['id']); 
		}

		if(Probe::_delete($probeId)){

			Session::flash('success_message', 'Se ha eliminado el sondeo correctamente'); 

		   	return Redirect::to(URL::action('ProbeController@index', array($values['project_id'])));

		}else{
		   	
		   	Session::flash('error_message', 'No se ha podido eliminar el sondeo'); 

		   	return Redirect::to(URL::action('ProbeController@index', array($values['project_id'])));			
		} 

	}

	public function getProbeInfo($probeId) {

		$probe = (array) Probe::getProbeInfo($probeId); 

		//probe status
	   	$probeStatus = array(
	   		'1'			=> 'Cerrado',
	   		'2'			=> 'Abierto'
	   	);

	    if(!empty($probe)){

	      $result = array(
	          'error'  			=> false,
	          'data'			=> $probe,
	          'probe_status'	=> $probeStatus
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);			

	}

	public function saveProbeInfo(){

		// get probe values
		$values = Input::get('values');

		$probeInfoData = array(
			'title'				=> $values['title'],
			'description'		=> $values['description'],
			'status'			=> $values['status']
		);

	    if(Probe::_update($values['probe_id'], $probeInfoData)){

	    	$probe = (array) Probe::getProbeInfo($values['probe_id']); 

	      $result = array(
	          'error'   => false,
	          'data'	=> $probe
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);	
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

	public function saveNewProbeOption(){


		 $values = Input::get('values');

		 $option = array(
		 	'name'						=> $values['name'],
		 	'probe_template_element_id'	=> $values['question_id']
		 );

		 $insertedOptionId = Probe::saveQuestionOption($option);
		 if($insertedOptionId>0){

		 	$element = (array) Probe::getOptionData($insertedOptionId); 

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

	public function deleteQuestion($questionId) {

		 if(Probe::deleteQuestion($questionId)) {

		      $result = array(
		          'error'   => false
		      );		 	

		 }else{

		      $result = array(
		          'error'     => true
		      );		 	

		 } 

	      header('Content-Type: application/json');
	      return Response::json($result);			 

	}

	public function deleteOption($optionId) {

		 if(Probe::deleteOptionResponses($optionId) && Probe::deleteOption($optionId)) {

		      $result = array(
		          'error'   => false
		      );		 	

		 }else{

		      $result = array(
		          'error'     => true
		      );		 	

		 } 

	      header('Content-Type: application/json');
	      return Response::json($result);			 

	}

	public function getProbeResults($probeId){

		// get probe results 
		$probeResults = Probe::getProbeResults($probeId); 

		//print_r($probeResults); die; 

		$graphicsArray = array(); 

		foreach($probeResults['elements'] as $index => $element){

			if($element['form_element']==Config::get('constant.probe.element.checkbox') || $element['form_element']==Config::get('constant.probe.element.radio')) {

				// create table with results for closed questions
				$tableResults = Lava::DataTable();

				$tableResults->addStringColumn('Opcion')
		       				 ->addNumberColumn('Resultados');

				foreach($element['results'] as $result){

					// add rows to table with data
					$tableResults->addRow(array($result['name'], $result['result_count'])); 

				}

				// create graphic for each question
				$piechart = Lava::PieChart('graphic-'.$index)
				                 ->setOptions(array(
				                   'datatable' => $tableResults,
				                   'title' => $element['question'],
				                   'is3D' => true,
				                   'colors' => array(
				                         '#41cac0',
				                         '#ec8f6e',
				                         '#a8d76f',
				                         '#eecb44',
				                         '#ef6f66',
				                         '#9E71A8',
				                         '#B5D6EB',
				                         '#CD3B71',
				                         '#EC7143',
				                         '#ECD943',
				                         '#EC4843',
				                         '#EC8443'

				                      )
				                  ));	

				// save each graphic on global array
				$graphicsArray[$index] = $piechart; 

			}

		}

		return View::make('frontend.probe.results')->with('graphicsArray', $graphicsArray)
												 	->with('probeTitle', $probeResults['title']);             	
	}	


}
