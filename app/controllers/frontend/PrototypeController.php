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
		    				->with('PrototypeName', $PrototypeId['title'])
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
		   		'iteration_id'  	=> $values['iteration_id'],
		   		'url'				=> md5($values['title'].date('H:i:s'))

		  );

		  $project = (array) Project::getName($values['project_id']);	
		  $PrototypeCount = Prototype::insertPrototype($Prototypediagram); 
		 
		 

		  if($PrototypeCount>0){


		  	//Session::flash('success_message', 'Se creó el nombre del diagrama'); 

                // redirect to index probre view
                return Redirect::to(URL::action('PrototypeController@showdiagram', array($PrototypeCount, $values['project_id'], $values['iteration_id'])));

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
	    					->with('iterationId', $iterationId)
		    				->with('projectId', $projectId)
		    				->with('PrototypeName', $Prototype_d['title'])
		    				->with('PrototypeId', $Prototype_d['id'])
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

	    	
	    	$infoproject = Prototype::getPrototypeInfo($PrototypeId);

			if(Prototype::deletePrototype($PrototypeId)){

				Session::flash('success_message', 'Se ha eliminado el diagrama correctamente'); 

			   	return Redirect::to(URL::action('PrototypeController@index', array($infoproject['id_project'], $infoproject['iteration_id'])));

			}else{
			   	
			   	Session::flash('error_message', 'No se pudo eliminar el diagrama'); 

			   	return Redirect::to(URL::action('PrototypeController@index', array($infoproject['id_project'], $infoproject['iteration_id'])));			
			} 

		}

			
	}

	public function update_name($PrototypeId){
		$nameProto= Input::get('values');
	   
		//echo "hola";
		$Prototypename = array(

			'title'	=> $nameProto['title']

		);

		if(Prototype::editPrototype($PrototypeId, $Prototypename)){

			$Prototypetitle = (array) Prototype::getPrototypeInfo($PrototypeId); 

			$result = array(
	          'error'   => false,
	          'data'	=> $Prototypetitle
	      );

		}else{

			$result = array(
	          'error'     => true
	      );

		}
		
		
		//print_r($result['data']); die;
		
	     header('Content-Type: application/json');
	     return Response::json($result);
	}

	public function getInfo($PrototypeId){

		$ProtoInfo = (array) Prototype::getPrototypeInfo($PrototypeId);

		
 		if(!empty($ProtoInfo)){
			$resultado = array(
				          'error'   => false,
				          'data'	=> $ProtoInfo
		     			);

		}else{

			$resultado = array(

		          'error'   => true
		          
		     );
		}

		
 		header('Content-Type: application/json');
	    return Response::json($resultado);			


 	}

public function send_prototype(){

 		if(Input::has('_token')){	
 
        // validation rules
	        $rules =  array(
	          'email'              => 'required|email',
	          
	        );

	        $values = Input::all();
	        
	        $user = Session::get('user');
	   
			 $email_checked = Input::get('email');
			
			foreach ($email_checked as $mailuser) {
			
		 		 $emailData = array(
		                      'url_token'       => URL::to('/'). '/prototipo/mostrar/'. $values['PrototypeId'] . '/ '. $values['projectId'] . '/'. $values['iterationId'],
		                      'user_name'       => $user['first_name'].' '.$user['last_name'],
		                      'project_name'    => $values['projectName'],
		                      'iteration_name'  => $values['iterationName'],
		                      'artefact_name'	=> "Prototipo",
		                      'mensaje'			=> $values['mensaje']
		          
		           );

		 		 	//print_r($mailuser);
		                    // send email with invitation to registered user
		           Mail::send('frontend.email_templates.seeArtefact', $emailData, 

		                  function($message) use ($mailuser){

		                      $message->to($mailuser);
		                      $message->subject('PROAGIL: Invitación a revisar artefacto');
		           }); 
		    }



		  	Session::flash('success_message', 'Se envió el correo'); 

		 	
		  	

                // redirect to index probre view
              return Redirect::to(URL::action('PrototypeController@index', array($values['projectId'], $values['iterationId'])));

		  

		  


		  }else{

		  	Session::flash('error_message', 'No se pudo enviar el correo'); 

		   	return Redirect::to(URL::action('PrototypeController@index', array($values['projectId'], $values['iterationId'])));

		  }
     	

 }

 	public function getInfoIter($iterationId){

 		$colaborators = Iteration::getColaboratorOnIteration($iterationId); 
 		

 		//$usuario= User::getUserById($colaborators);
 		
 		if(!empty($colaborators)){
 		$resultado = array(

                  'error'    => false,
                  'data'   => $colaborators,
                
                  
          );

 		}else{

 		$resultado = array(

		          'error'   => true	
		          );
 		}

 	

		
 		header('Content-Type: application/json');
	    return Response::json($resultado);			




 	}
 }

