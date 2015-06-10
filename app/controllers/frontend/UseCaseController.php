<?php

class UseCaseController extends BaseController {

	public function index($projectId, $iterationId){

		$user = Session::get('user');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 

		if(!$permission){

			 return Redirect::to(URL::action('LoginController@index'));

		}else{
			if(is_null(Session::get('user'))){

		          return Redirect::to(URL::action('DashboardController@index'));

		    }else{

		    	//get user role
		    	 $userRole = Session::get('user_role');

		    	 // get project data
		    	 $project = (array) Project::getName($projectId); 
		    	 // get iteration data
		    	 $iteration = (array) Iteration::get($iterationId);

		    	 $UseCase = Use_case::enumerate($iterationId);

		    	 $UsecaseId = Use_case::getId($projectId);

		    	return View::make('frontend.diagrams.use_case.index')
		    				->with('iteration', $iteration)
		    				->with('iterationId', $iterationId)
		    				->with('projectName', $project['name'])
		    				->with('projectId', $projectId)
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
		    				->with('usecaseId', $UsecaseId['id'])
		    				->with('UseCase', $UseCase);

		    }			

		}
	    


	}

	public function create($projectId, $iterationId){



		$user = Session::get('user');
	    $userRole = Session::get('user_role');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 
		
	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){
	    	echo "entro al create y al if";

	    	// get project data
	    	$project = (array) Project::getName($projectId); 

	    	$iteration = (array) Iteration::get($iterationId); 

	    	return View::make('frontend.diagrams.use_case.create')
		    				->with('iteration', $iteration)
		    				->with('projectId', $projectId)
		    				->with('projectName', $project['name'])
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
		  

		}else{

			

		    	return Redirect::to(URL::action('DashboardController@index'));

		 }
	}

	public function update(){	


		$result= Input::all();
	
		$usecaseInfoDiagrama = json_encode($result['diagrama']);
			
	
		
		//print_r($usecaseInfoDiagrama); die;

		$usecaseInfoData = array(

			'diagrama'	=> $usecaseInfoDiagrama

		);

		if(Use_case::editUseCase($result['id'], $usecaseInfoData)){

			$use_case = (array) Use_case::getUseCaseInfo($result['id']); 

			$result = array(
	          'error'   => false,
	          'data'	=> $use_case
	      );

		}else{

			$result = array(
	          'error'     => true
	      );

		}
		
		
		//print_r($result['diagrama']); die;
		
	     header('Content-Type: application/json');
	     return Response::json($result);

	}



	public function save(){

		
		 $values = Input::get('use_case');

		 $usecase = array(
		   		
		   		'id_project'		=> $values['project_id'],
		   		'diagrama'			=> NULL,
		   		'title'				=> $values ['title'],
		   		'iteration_id'  	=> $values['iteration_id']

		  );

		  $project = (array) Project::getName($values['project_id']);	
		  $usecaseid = Use_case::insertUseCase($usecase); 

		  if($usecaseid>0){

		  	Session::flash('success_message', 'Se creó el nombre del diagrama'); 

                // redirect to index probre view
                return Redirect::to(URL::action('UseCaseController@index', array($values['project_id'], $values['iteration_id'])));

		  }else{

		  	Session::flash('error_message', 'No se pudo crear el nombre del diagrama'); 

		   		return Redirect::to(URL::action('UseCaseController@index', array($values['project_id'], $values['iteration_id'])));


		  }
	}


	public function showdiagram($use_caseid, $projectId, $iterationId ){


		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($use_caseid, 'use_diagram', $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){ 

	    	// $diagramdata = Use_case::getProbeElements($probeId); 
	    	$project = (array) Project::getName($projectId); 

	    	$iteration = (array) Iteration::get($iterationId);

	    	$usecase =  (array) Use_case::getName($use_caseid); 

	    	//$diagrama =  (array) Use_case::getUseCaseInfo($use_caseid); 

	    	//importante pasarle el diagrama
	    	return View::make('frontend.diagrams.use_case.show')
	    					->with('iteration', $iteration)
		    				->with('projectId', $projectId)
		    				->with('use_caseName', $usecase['title'])
		    				->with('use_caseId', $use_caseid)
		    				->with('usecaseDiagram', $usecase['diagrama'])
		    				->with('projectName', $project['name'])
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);

	    }else{



	    return Redirect::to(URL::action('LoginController@index'));

	     }

	}



	public function getdiagram($usecaseId){	


		$diagram = (array) Use_case::getUseCaseInfo($usecaseId); 


		//print_r($diagram['diagrama']);
		  if(!empty($diagram)){

	      $result = array(
	          'error'  			=> false,
	          'data'			=> json_decode($diagram['diagrama']),
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }

	      header('Content-Type: application/json');
	      return Response::json($result);			
		

	}

	public function eliminar($usecaseId){


		$user = Session::get('user');

	    $permission = User::userHasPermissionOnArtefact($usecaseId, 'use_diagram', $user['id']);  

	    if(!$permission){

	    	return Redirect::to(URL::action('LoginController@index'));

	    }else{    

	    	
	    	$infoproject = Use_case::getUseCaseInfo($usecaseId);

			if(Use_case::deleteUseCase($usecaseId)){

				Session::flash('success_message', 'Se ha eliminado el diagrama correctamente'); 

			   	return Redirect::to(URL::action('UseCaseController@index', array($infoproject['id_project'], $infoproject['iteration_id'])));

			}else{
			   	
			   	Session::flash('error_message', 'No se pudo eliminar el diagrama'); 

			   	return Redirect::to(URL::action('UseCaseController@index', array($infoproject['id_project'], $infoproject['iteration_id'])));			
			} 

		}

			
	}


	
}
