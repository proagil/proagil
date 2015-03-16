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

		   		// get project name
		   		$project = (array) Project::getName($values['project_id']);

		   		Session::flash('success_message', 'Se ha creado el Sondeo exitosamente en su proyecto: '.$project['name']); 

                // redirect to invitation view
                return Redirect::to(URL::action('ProbeController@index', array($values['project_id'])));
		   	}

		   }else{

		   }
	}



}
