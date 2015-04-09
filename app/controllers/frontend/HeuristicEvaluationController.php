<?php

class HeuristicEvaluationController extends BaseController {

	public function index($projectId){

	    if(is_null(Session::get('user'))){

	          return Redirect::to(URL::action('DashboardController@index'));

	    }else{

	    	//get user role
	    	 $userRole = Session::get('user_role');

	    	 // get project data
	    	 $project = (array) Project::getName($projectId); 

	    	 $evaluations = HeuristicEvaluation::enumerate($projectId); 

	    	return View::make('frontend.heuristicEvaluation.index')
	    		    	->with('projectName', $project['name'])
	    				->with('projectId', $projectId)
	    				->with('evaluations', $evaluations)
	    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE); 

	    }

	}

	public function create($projectId){

		// get user role
	    $userRole = Session::get('user_role');
   

	    if($userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	 $project = (array) Project::getName($projectId); 

	    	 // get heuristics
	    	 $heuristics = HeuristicEvaluation::getHeuristics(); 

	    	 // get valorations
	    	 $valorations = HeuristicEvaluation::getValorations(); 	    	

	    	return View::make('frontend.heuristicEvaluation.create')
	    		    	->with('projectName', $project['name'])
	    		    	->with('heuristics', $heuristics)
	    		    	->with('valorations', $valorations)
	    				->with('projectId', $projectId); 

	    }else{

	    	 return Redirect::to(URL::action('DashboardController@index'));

	    }
	}

	public function save() {

		$values = Input::get('evaluation');


		$evaluation = array(
			'name'			=> 	$values['name'],
			'project_id'	=> $values['project_id']
		);

		$evaluationId = HeuristicEvaluation::insert($evaluation);

		if($evaluationId>0){

			foreach($values['values'] as $problem){

				$evaluationItem = array(
					'heuristic_id'				=> $problem['heuristic'],
					'problem' 					=> $problem['problem'],
					'valoration_id'				=> $problem['valoration'],
					'solution'					=> $problem['solution'],
					'heuristic_evaluation_id'	=> $evaluationId

				);

				HeuristicEvaluation::saveProblem($evaluationItem);

			}

		 		// get project data
			    $project = (array) Project::getName($values['project_id']); 	 
		   		Session::flash('success_message', 'Se ha creado la evaluaci&oacute;n heur&iacute;stica exitosamente en su proyecto: '.$project['name']); 

                // redirect to index probre view
                return Redirect::to(URL::action('HeuristicEvaluationController@index', array($values['project_id'])));			

		}else{

		   		Session::flash('error_message', 'No se ha podido crear la evaluaci&oacute;n heur&iacute;stica en su proyecto: '.$project['name']); 

		   		return Redirect::to(URL::action('HeuristicEvaluationController@index', array($values['project_id'])));
		}

	}

	public function getEvaluation($evaluationId){

		$evaluation = HeuristicEvaluation::getEvaluationData($evaluationId);

		if(!empty($evaluation)){

			// get project data
			 $project = (array) Project::getName($evaluation['project_id']); 		

			return View::make('frontend.heuristicEvaluation.detail')
						->with('evaluation', $evaluation)
						->with('projectName', $project['name']);  			

		}else{

			return Redirect::to(URL::action('DashboardController@index'));

		}

	}

	public function edit($evaluationId) {

		$evaluation = HeuristicEvaluation::getEvaluationData($evaluationId);

		if(!empty($evaluation)){

			// get project data
			 $project = (array) Project::getName($evaluation['project_id']); 

	    	 // get heuristics
	    	 $heuristics = HeuristicEvaluation::getHeuristics(); 

	    	 // get valorations
	    	 $valorations = HeuristicEvaluation::getValorations(); 	    	

			return View::make('frontend.heuristicEvaluation.edit')
						->with('evaluation', $evaluation)
						->with('projectName', $project['name'])
						->with('projectId', $project['id'])
						->with('heuristics', $heuristics)
						->with('valorations', $valorations)
						->with('evaluationId', $evaluationId);   			

		}else{

			return Redirect::to(URL::action('DashboardController@index'));

		}		

	}

	public function saveEvaluationInfo() {

		$values = Input::get('values');

		$evaluation = array(
			'name'			=> 	$values['name']
		);

		 if(HeuristicEvaluation::edit($values['evaluation_id'], $evaluation)){

		 	$element = (array) HeuristicEvaluation::getEvaluationData($values['evaluation_id']); 

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

	public function saveNewElement(){

		$values = Input::get('evaluation');

		$evaluation = array(
			'problem'					=> $values['problem'],
			'solution' 					=> $values['solution'],
			'heuristic_evaluation_id'	=> $values['evaluation_id'],
			'heuristic_id'				=> $values['heuristic'],
			'valoration_id'				=> $values['valoration']

		);

		 if(HeuristicEvaluation::saveProblem($evaluation)) {

			return Redirect::to(URL::action('HeuristicEvaluationController@edit', $values['evaluation_id']));		 	

		 }else{

				return Redirect::to(URL::action('HeuristicEvaluationController@edit', $values['evaluation_id']));	
		 } 

	}

	public function deleteElement($elementId) {

		 if(HeuristicEvaluation::deleteElement($elementId)) {

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

	public function deleteEvaluation($evaluationId){

		$values = HeuristicEvaluation::getEvaluationData($evaluationId); 
		
		// delete all heuristic evaluation values for each heuristic evaluation
		foreach($values['elements'] as $element){

			HeuristicEvaluation::deleteElement($element['id']); 
		}

		if(HeuristicEvaluation::_delete($evaluationId)){

			Session::flash('success_message', 'Se ha eliminado la evaluaci&oacute;n heur&iacute;stica correctamente'); 

		   	return Redirect::to(URL::action('HeuristicEvaluationController@index', array($values['project_id'])));

		}else{
		   	
		   	Session::flash('error_message', 'No se ha podido eliminar el evaluaci&oacute;n heur&iacute;stica'); 

		   	return Redirect::to(URL::action('HeuristicEvaluationController@index', array($values['project_id'])));			
		} 

	}


	public function getEvaluationInfo($evaluationId) {

		$element = (array) HeuristicEvaluation::getEvaluationData($evaluationId); 

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


	public function getElement($elementId) {

		$element = (array) HeuristicEvaluation::getElementData($elementId); 

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

	public function saveElement() {

		$values = Input::get('values');

		 $element = array(
		 	'heuristic_id'			=> $values['heuristic_id'],
		 	'valoration_id'			=> $values['valoration_id'],
		 	'solution'				=> $values['solution'],
		 	'problem'				=> $values['problem'],
		 );

		 if(HeuristicEvaluation::updateElement($values['element_id'], $element)){

		 	$element = (array) HeuristicEvaluation::getElementData($values['element_id']); 

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
