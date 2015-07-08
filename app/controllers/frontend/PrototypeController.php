<?php

class PrototypeController extends BaseController {

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

		    	 $Prototype_d = Prototype::enumerate($iterationId);

		    	 $PrototypeId = Prototype::getId($projectId);

		    	return View::make('frontend.prototype.index')
		    				->with('iteration', $iteration)
		    				->with('iterationId', $iterationId)
		    				->with('projectName', $project['name'])
		    				->with('projectId', $projectId)
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
		    				->with('PrototypeId', $PrototypeId['id'])
		    				->with('Prototype_d', $Prototype_d);

		    }			

		}
	    


	}

	public function create($projectId, $iterationId){



		$user = Session::get('user');
	    $userRole = Session::get('user_role');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 
		
	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){
	    	//echo "entro al create y al if";

	    	// get project data
	    	$project = (array) Project::getName($projectId); 

	    	$iteration = (array) Iteration::get($iterationId); 

	    	return View::make('frontend.prototype.create')
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
	
		$PrototypeInfoDiagrama = json_encode($result['diagrama']);
			
	
		
		//print_r($usecaseInfoDiagrama); die;

		$PrototypeInfoData = array(

			'prototipo'	=> $PrototypeInfoDiagrama

		);

		if(Prototype::editPrototype($result['id'], $PrototypeInfoData)){

			$PrototypeDiagram = (array) Prototype::getPrototypeInfo($result['id']); 

			$result = array(
	          'error'   => false,
	          'data'	=> $PrototypeDiagram
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

		
		 $values = Input::get('prototipo');

		 $Prototypediagram = array(
		   		
		   		'id_project'		=> $values['project_id'],
		   		'prototipo'			=> NULL,
		   		'title'				=> $values ['title'],
		   		'iteration_id'  	=> $values['iteration_id']

		  );

		  $project = (array) Project::getName($values['project_id']);	
		  $PrototypeId = Prototype::insertPrototype($Prototypediagram); 

		  if($PrototypeId>0){

		  	Session::flash('success_message', 'Se creó el nombre del diagrama'); 

                // redirect to index probre view
                return Redirect::to(URL::action('PrototypeController@index', array($values['project_id'], $values['iteration_id'])));

		  }else{

		  	Session::flash('error_message', 'No se pudo crear el nombre del diagrama'); 

		   		return Redirect::to(URL::action('PrototypeController@index', array($values['project_id'], $values['iteration_id'])));


		  }
	}


	public function showdiagram($PrototypeId, $projectId, $iterationId ){


		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($PrototypeId, 'prototype', $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){ 

	    	// $diagramdata = Use_case::getProbeElements($probeId); 
	    	$project = (array) Project::getName($projectId); 

	    	$iteration = (array) Iteration::get($iterationId);

	    	$Prototype_d =  (array) Prototype::getName($PrototypeId); 

	    	//$diagrama =  (array) Use_case::getUseCaseInfo($use_caseid); 

	    	//importante pasarle el diagrama
	    	return View::make('frontend.prototype.show')
	    					->with('iteration', $iteration)
		    				->with('projectId', $projectId)
		    				->with('PrototypeName', $Prototype_d['title'])
		    				->with('PrototypeId', $PrototypeId)
		    				->with('PrototypeDiagram', $Prototype_d['prototipo'])
		    				->with('projectName', $project['name'])
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);

	    }else{



	    return Redirect::to(URL::action('LoginController@index'));

	     }

	}



	public function getdiagram($PrototypeId){	


		$diagram = (array) Prototype::getPrototypeInfo($PrototypeId); 


		//print_r($diagram['diagrama']);
		  if(!empty($diagram)){

	      $result = array(
	          'error'  			=> false,
	          'data'			=> json_decode($diagram['prototipo']),
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }

	      header('Content-Type: application/json');
	      return Response::json($result);			
		

	}

	public function eliminar($PrototypeId){


		$user = Session::get('user');

	    $permission = User::userHasPermissionOnArtefact($PrototypeId, 'prototype', $user['id']);  

	    if(!$permission){

	    	return Redirect::to(URL::action('LoginController@index'));

	    }else{    

	    	
	    	$infoproject = Prototype::getUseCaseInfo($PrototypeId);

			if(Prototype::deletePrototype($PrototypeId)){

				Session::flash('success_message', 'Se ha eliminado el diagrama correctamente'); 

			   	return Redirect::to(URL::action('PrototypeController@index', array($infoproject['id_project'], $infoproject['iteration_id'])));

			}else{
			   	
			   	Session::flash('error_message', 'No se pudo eliminar el diagrama'); 

			   	return Redirect::to(URL::action('PrototypeController@index', array($infoproject['id_project'], $infoproject['iteration_id'])));			
			} 

		}

			
	}


}
