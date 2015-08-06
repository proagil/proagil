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
		    				->with('usecaseName', $UsecaseId['title'])
		    				->with('UseCase', $UseCase);

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

	    	return View::make('frontend.diagrams.use_case.create')
		    				->with('iterationId', $iteration['id'])
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
		   		'iteration_id'  	=> $values['iteration_id'],
		   		'url'				=> md5($values['title'].date('H:i:s'))

		  );

		  $project = (array) Project::getName($values['project_id']);	
		  $usecaseCount = Use_case::insertUseCase($usecase); 
		  $ucid= (array) Use_case::getIdbyName($values['title']);

		  if($usecaseCount>0){

		  	//Session::flash('success_message', 'Se creó el nombre del diagrama'); 

                // redirect to index probre view
                return Redirect::to(URL::action('UseCaseController@showdiagram', array($ucid['id'], $values['project_id'], $values['iteration_id'])));

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
	    					->with('iterationId', $iteration['id'])
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
	public function update_name($usecaseId){
		$nameUse= Input::get('values');
	   
		//echo "hola";
		$UseCasename = array(

			'title'	=> $nameUse['title']

		);

		if(Use_case::editUseCase($usecaseId, $UseCasename)){

			$UseCasetitle = (array) Use_case::getUseCaseInfo($usecaseId); 

			$result = array(
	          'error'   => false,
	          'data'	=> $UseCasetitle
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

	public function getInfo($usecaseId){

		$UseCaseInfo = (array) Use_case::getUseCaseInfo($usecaseId);

		
 		if(!empty($UseCaseInfo)){
			$resultado = array(
				          'error'   => false,
				          'data'	=> $UseCaseInfo
		     			);

		}else{

			$resultado = array(

		          'error'   => true
		          
		     );
		}

		
 		header('Content-Type: application/json');
	    return Response::json($resultado);			


 	}

public function send_useDiagram(){

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
		                      'url_token'       => URL::to('/'). '/diagrama-de-casos-de-uso/mostrar/'. $values['UseCaseId'] . '/ '. $values['projectId'] . '/'. $values['iterationId'],
		                      'user_name'       => $user['first_name'].' '.$user['last_name'],
		                      'project_name'    => $values['projectName'],
		                      'iteration_name'  => $values['iterationName'],
		                      'artefact_name'	=> "Diagrama de Casos de Uso",
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
              return Redirect::to(URL::action('UseCaseController@index', array($values['projectId'], $values['iterationId'])));

		  

		  


		  }else{

		  	Session::flash('error_message', 'No se pudo enviar el correo'); 

		   	return Redirect::to(URL::action('UseCaseController@index', array($values['projectId'], $values['iterationId'])));

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
