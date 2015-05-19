<?php

class HeuristicEvaluationController extends BaseController {

	 public function __construct(){

	      //not user on session
	      $this->beforeFilter(function(){

	        if(is_null(Session::get('user'))){
	          return Redirect::to(URL::action('LoginController@index'));
	        }

	      });
	 }


	public function index($projectId, $iterationId){

		$user = Session::get('user');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 			

	    if(is_null(Session::get('user')) || !$permission){

	          return Redirect::to(URL::action('DashboardController@index'));

	    }else{

	    	//get user role
	    	 $userRole = Session::get('user_role');

	    	 // get project data
	    	 $project = (array) Project::getName($projectId); 

	    	// get iteration data
	    	$iteration = (array) Iteration::get($iterationId);

	    	$evaluations = HeuristicEvaluation::enumerate($iterationId); 

	    	return View::make('frontend.heuristicEvaluation.index')
	    				->with('evaluations', $evaluations)
	    				->with('iteration', $iteration)
	    				->with('projectId', $projectId)
	    		    	->with('projectName', $project['name'])
	    				->with('projectId', $projectId)
	    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE); 

	    }

	}

	public function create($projectId, $iterationId){

		// get user role
	    $userRole = Session::get('user_role');

		$user = Session::get('user');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 		    
   

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	 $project = (array) Project::getName($projectId); 

	    	// get iteration data
	    	$iteration = (array) Iteration::get($iterationId);	    	 

	    	// get heuristics
	    	$heuristics = HeuristicEvaluation::getHeuristics(); 

	    	// get valorations
	    	$valorations = HeuristicEvaluation::getValorations(); 	    	

	    	return View::make('frontend.heuristicEvaluation.create')
	    		    	->with('heuristics', $heuristics)
	    		    	->with('iteration', $iteration)
	    				->with('projectId', $projectId)
	    		    	->with('projectName', $project['name'])
	    		    	->with('valorations', $valorations);

	    }else{

	    	 return Redirect::to(URL::action('DashboardController@index'));

	    }
	}

	public function save() {

		$values = Input::get('evaluation');


		$evaluation = array(
			'name'			=> $values['name'],
			'project_id'	=> $values['project_id'],
			'iteration_id'  => $values['iteration_id']
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

	   		Session::flash('success_message', 'Se creó la evaluaci&oacute;n heur&iacute;stica'); 

	        // redirect to index probre view
	        return Redirect::to(URL::action('HeuristicEvaluationController@index', array($values['project_id'], $values['iteration_id'])));			

		}else{

	   		Session::flash('error_message', 'Ocurrió un problema y no se creó la evaluaci&oacute;n heur&iacute;stica'); 

	   		return Redirect::to(URL::action('HeuristicEvaluationController@index', array($values['project_id'], $values['iteration_id'])));
		}

	}

	public function getEvaluation($evaluationId){

		$user = Session::get('user');

		$permission = User::userHasPermissionOnArtefact($evaluationId, 'heuristic_evaluation', $user['id']); 		

		$evaluation = HeuristicEvaluation::getEvaluationData($evaluationId);

		if(!empty($evaluation) && $permission){

			// get project data
			 $project = (array) Project::getName($evaluation['project_id']);


	    	// get iteration data
	    	$iteration = (array) Iteration::get($evaluation['iteration_id']);	    		

			return View::make('frontend.heuristicEvaluation.detail')
						->with('evaluation', $evaluation)
						->with('iteration', $iteration)
						->with('projectName', $project['name']);  			

		}else{

			return Redirect::to(URL::action('DashboardController@index'));

		}

	}

	public function export($evaluationId){

		$user = Session::get('user');

		$permission = User::userHasPermissionOnArtefact($evaluationId, 'heuristic_evaluation', $user['id']); 

		$evaluation = HeuristicEvaluation::getEvaluationData($evaluationId);

		if(!empty($evaluation) && $permission){

			// get project data
			 $project = (array) Project::getName($evaluation['project_id']); 	


        $pdf = PDF::loadView('frontend.heuristicEvaluation.export', $evaluation);

        return $pdf->download('proagil-'.$evaluation['name'].'.pdf');			 
		

		}else{

			return Redirect::to(URL::action('DashboardController@index'));

		}

	}	

	public function edit($evaluationId) {

		$user = Session::get('user');

		$permission = User::userHasPermissionOnArtefact($evaluationId, 'heuristic_evaluation', $user['id']); 

		$evaluation = HeuristicEvaluation::getEvaluationData($evaluationId);

		if(!empty($evaluation) && $permission){

			// get project data
			 $project = (array) Project::getName($evaluation['project_id']);

	    	// get iteration data
	    	$iteration = (array) Iteration::get($evaluation['iteration_id']);	  

	    	 // get heuristics
	    	 $heuristics = HeuristicEvaluation::getHeuristics(); 

	    	 // get valorations
	    	 $valorations = HeuristicEvaluation::getValorations(); 	    	

			return View::make('frontend.heuristicEvaluation.edit')
						->with('evaluation', $evaluation)
						->with('evaluationId', $evaluationId)   			
						->with('heuristics', $heuristics)
						->with('iteration', $iteration)
						->with('projectId', $project['id'])
						->with('projectName', $project['name'])
						->with('valorations', $valorations);

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

		$user = Session::get('user');

		$permission = User::userHasPermissionOnArtefact($evaluationId, 'heuristic_evaluation', $user['id']); 

		if(!$permission){

			return Redirect::to(URL::action('DashboardController@index'));

		}else{

			$values = HeuristicEvaluation::getEvaluationData($evaluationId); 
			
			// delete all heuristic evaluation values for each heuristic evaluation
			foreach($values['elements'] as $element){

				HeuristicEvaluation::deleteElement($element['id']); 
			}

			if(HeuristicEvaluation::_delete($evaluationId)){

				Session::flash('success_message', 'Se ha eliminado la evaluaci&oacute;n heur&iacute;stica correctamente'); 

			   	return Redirect::to(URL::action('HeuristicEvaluationController@index', array($values['project_id'], $values['iteration_id'])));

			}else{
			   	
			   	Session::flash('error_message', 'No se pudo eliminar el evaluaci&oacute;n heur&iacute;stica'); 

			   	return Redirect::to(URL::action('HeuristicEvaluationController@index', array($values['project_id'], $values['iteration_id'])));			
			} 

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
