<?php

class DomainObjectController extends BaseController {

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

		    	 $object_d = Object::enumerate($iterationId);

		    	 $objectId = Object::getId($projectId);

		    	return View::make('frontend.diagrams.domain_object.index')
		    				->with('iteration', $iteration)
		    				->with('iterationId', $iterationId)
		    				->with('projectName', $project['name'])
		    				->with('projectId', $projectId)
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
		    				->with('objectId', $objectId['id'])
		    				->with('object_d', $object_d);

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

	    	return View::make('frontend.diagrams.domain_object.create')
		    				->with('iteration', $iteration)
		    				->with('iterationId', $iterationId)
		    				->with('projectId', $projectId)
		    				->with('projectName', $project['name'])
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
		  

		}else{

			

		    	return Redirect::to(URL::action('DashboardController@index'));

		 }
	}

	public function update(){	


		$result= Input::all();
	
		$objectInfoDiagrama = json_encode($result['diagrama']);
			
	
		
		//print_r($usecaseInfoDiagrama); die;

		$objectInfoData = array(

			'diagrama'	=> $objectInfoDiagrama

		);

		if(Object::editObject($result['id'], $objectInfoData)){

			$objectd = (array) Object::getObjectInfo($result['id']); 

			$result = array(
	          'error'   => false,
	          'data'	=> $objectd
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

		
		 $values = Input::get('object');

		 $objectdiagram = array(
		   		
		   		'id_project'		=> $values['project_id'],
		   		'diagrama'			=> NULL,
		   		'title'				=> $values ['title'],
		   		'iteration_id'  	=> $values['iteration_id'],
		   		'url'				=> md5($values['title'].date('H:i:s'))

		  );

		  $project = (array) Project::getName($values['project_id']);	
		  $objectCount = Object::insertObject($objectdiagram); 
		   $objectId= (array) Object::getId($values['project_id']);

		  if($objectCount>0){

		  	//Session::flash('success_message', 'Se creó el nombre del diagrama'); 

                // redirect to index probre view
                return Redirect::to(URL::action('DomainObjectController@showdiagram', array($objectId['id'], $values['project_id'], $values['iteration_id'])));

		  }else{

		  	Session::flash('error_message', 'No se pudo crear el nombre del diagrama'); 

		   		return Redirect::to(URL::action('DomainObjectController@index', array($values['project_id'], $values['iteration_id'])));


		  }
	}


	public function showdiagram($objectId, $projectId, $iterationId ){


		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($objectId, 'object_diagram', $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){ 

	    	// $diagramdata = Use_case::getProbeElements($probeId); 
	    	$project = (array) Project::getName($projectId); 

	    	$iteration = (array) Iteration::get($iterationId);

	    	$object_d =  (array) Object::getName($objectId); 

	    	//$diagrama =  (array) Use_case::getUseCaseInfo($use_caseid); 

	    	//importante pasarle el diagrama
	    	return View::make('frontend.diagrams.domain_object.show')
	    					->with('iterationId', $iteration['id'])
		    				->with('projectId', $projectId)
		    				->with('objectName', $object_d['title'])
		    				->with('objectId', $objectId)
		    				->with('objectDiagram', $object_d['diagrama'])
		    				->with('projectName', $project['name'])
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);

	    }else{



	    return Redirect::to(URL::action('LoginController@index'));

	     }

	}



	public function getdiagram($objectId){	


		$diagram = (array) Object::getObjectInfo($objectId); 


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

	public function eliminar($objectId){


		$user = Session::get('user');

	    $permission = User::userHasPermissionOnArtefact($objectId, 'object_diagram', $user['id']);  

	    if(!$permission){

	    	return Redirect::to(URL::action('LoginController@index'));

	    }else{    

	    	
	    	$infoproject = Object::getObjectInfo($objectId);

			if(Object::deleteObject($objectId)){

				Session::flash('success_message', 'Se ha eliminado el diagrama correctamente'); 

			   	return Redirect::to(URL::action('DomainObjectController@index', array($infoproject['id_project'], $infoproject['iteration_id'])));

			}else{
			   	
			   	Session::flash('error_message', 'No se pudo eliminar el diagrama'); 

			   	return Redirect::to(URL::action('DomainObjectController@index', array($infoproject['id_project'], $infoproject['iteration_id'])));			
			} 

		}

			
	}


}
