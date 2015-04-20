<?php

class ExistingSystemController extends BaseController {

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

	    	 $existingSystems = ExistingSystem::enumerate($projectId); 

	    	return View::make('frontend.existingSystem.index')
	    		    	->with('projectName', $project['name'])
	    				->with('projectId', $projectId)
	    				->with('existingSystems', $existingSystems)
	    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE); 

	    }

	}

	public function create($projectId){

		// get user role
	    $userRole = Session::get('user_role');
   

	    if($userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	 $project = (array) Project::getName($projectId); 

	    	 // get existing system types
	    	 $topics = ExistingSystem::getExistingSystemTopics(); 


	    	return View::make('frontend.existingSystem.create')
	    		    	->with('projectName', $project['name'])
	    		    	->with('topics', $topics)
	    				->with('projectId', $projectId); 

	    }else{

	    	 return Redirect::to(URL::action('DashboardController@index'));

	    }
	}

	public function save() {

		$values = Input::get('esystem');

	   	// get system interface
	   	$interfaceFile = Input::file('interface');

	   	if($interfaceFile!=NULL){

	   		// save user avatar
	   		$imageId = $this->uploadAndResizeFile($interfaceFile, 500, 300); 
	   	}		

		$exystingSystem = array(
			'name'			=> 	$values['name'],
			'enabled'		=>  Config::get('constant.ENABLED'),
			'interface'		=> (isset($imageId))?$imageId:NULL,
			'project_id'	=> $values['project_id']
		);

		$existingSystemId = ExistingSystem::insert($exystingSystem);

		if($existingSystemId>0){

			foreach($values['values'] as $observation){

				$observation = array(
					'observation'				=> $observation['observation'],
					'existing_system_topic_id' 	=> $observation['topic'],
					'existing_system_id'		=> $existingSystemId,
					'project_id'				=> $values['project_id']

				);

				ExistingSystem::saveObservation($observation);

			}

		 		// get project data
			    $project = (array) Project::getName($values['project_id']); 	 
		   		Session::flash('success_message', 'Se ha creado el análisis de sistema existente'); 

                // redirect to index probre view
                return Redirect::to(URL::action('ExistingSystemController@index', array($values['project_id'])));			

		}else{

		   		Session::flash('error_message', 'No se pudo crear el análisis de sistema existente'); 

		   		return Redirect::to(URL::action('ProbeController@index', array($values['project_id'])));
		}

	}

	public function getExistingSystem($existingSystemId){

		$existingSystem = ExistingSystem::getExistingSystemData($existingSystemId);

		if(!empty($existingSystem)){

			// get project data
			 $project = (array) Project::getName($existingSystem['project_id']); 		

			return View::make('frontend.existingSystem.detail')
						->with('existingSystem', $existingSystem)
						->with('projectName', $project['name']);  			

		}else{

			return Redirect::to(URL::action('DashboardController@index'));

		}

	}

	public function edit($existingSystemId) {

		$existingSystem = ExistingSystem::getExistingSystemData($existingSystemId);

		if(!empty($existingSystem)){

			// get project data
			 $project = (array) Project::getName($existingSystem['project_id']); 

			 // get existing system types
	    	 $topics = ExistingSystem::getExistingSystemTopics(); 

			return View::make('frontend.existingSystem.edit')
						->with('existingSystem', $existingSystem)
						->with('projectName', $project['name'])
						->with('projectId', $project['id'])
						->with('topics', $topics)
						->with('existingSystemId', $existingSystemId);   			

		}else{

			return Redirect::to(URL::action('DashboardController@index'));

		}		

	}

	public function saveSystemInfo($existingSystemId) {

		$values = Input::get('esystem');

	   	// get system interface
	   	$interfaceFile = Input::file('interface');

	   	$existingSystem = ExistingSystem::getExistingSystemData($existingSystemId);

	   	if($interfaceFile!=NULL){

	   		// save user avatar
	   		$imageId = $this->uploadAndResizeFile($interfaceFile, 500, 300); 

	   		//delete old interface
       		if($existingSystem['interface']!=NULL || $existingSystem['interface']!=''){
       			$this->deleteFile($existingSystem['interface_image'], $existingSystem['interface']); 
       		}	   		
	   	}

	   	$values['interface_id'] = ($values['interface_id']==NULL)? NULL: $values['interface_id']; 		

		$exystingSystem = array(
			'name'			=> 	$values['name'],
			'interface'		=> (isset($imageId))?$imageId:$values['interface_id'],
		);

		if(ExistingSystem::edit($existingSystemId, $exystingSystem)){

		 	//Session::flash('success_message', 'Se creó el análisis de sistema existente'); 
 
            // redirect to edit existing system view
            return Redirect::to(URL::action('ExistingSystemController@edit', $existingSystemId));				

		}else{

            // redirect to edit existing system view
            return Redirect::to(URL::action('ExistingSystemController@edit', $existingSystemId));				

		}

	}

	public function saveNewElement(){

		$values = Input::get('esystem');

		$observation = array(
			'observation'				=> $values['observation'],
			'existing_system_topic_id' 	=> $values['topic'],
			'existing_system_id'		=> $values['system_id'],
			'project_id'				=> $values['project_id']

		);

		 if(ExistingSystem::saveObservation($observation)) {

			return Redirect::to(URL::action('ExistingSystemController@edit', $values['system_id']));		 	

		 }else{

				return Redirect::to(URL::action('ExistingSystemController@edit', $values['system_id']));	
		 } 

	}

	public function deleteElement($elementId) {

		 if(ExistingSystem::deleteElement($elementId)) {

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

	public function deleteExistingSystem($systemId){

		$values = ExistingSystem::getExistingSystemData($systemId); 
		
		// delete all existing system values for each existing system element
		foreach($values['elements'] as $element){

			ExistingSystem::deleteElement($element['id']); 
		}

		if(ExistingSystem::_delete($systemId)){

			Session::flash('success_message', 'Se ha eliminado el sistema existente correctamente'); 

		   	return Redirect::to(URL::action('ExistingSystemController@index', array($values['project_id'])));

		}else{
		   	
		   	Session::flash('error_message', 'No se pudo eliminar el sistema existente'); 

		   	return Redirect::to(URL::action('ExistingSystemController@index', array($values['project_id'])));			
		} 

	}


	public function getSystemInfo($systemId) {

		$element = (array) ExistingSystem::getExistingSystemData($systemId); 

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

		$element = (array) ExistingSystem::getElementData($elementId); 

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
		 	'existing_system_topic_id'			=> $values['topic_id'],
		 	'observation'						=> $values['observation'],
		 );

		 if(ExistingSystem::updateElement($values['element_id'], $element)){

		 	$element = (array) ExistingSystem::getElementData($values['element_id']); 

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

	public function uploadAndResizeFile($file, $width, $height) {

		// get client name and generate server name
		$clientName = $file->getClientOriginalName(); 
		$serverName = md5(time(). str_replace(' ', '_', $clientName)).'.'.$file->guessClientExtension();

		// move file into uploads folder and resize
		$file->move(public_path('uploads'), $serverName);
		$resizedFile = Image::make(sprintf(public_path('uploads/%s'), $serverName))->widen($width)->save();

		// save image on database and generate file id
		if($resizedFile!=NULL){

			$fileValues = array(
				'client_name'		=> $clientName,
				'server_name'		=> $serverName 
			);

			return $fileId = Files::insert($fileValues); 
		}

	}

	public function deleteFile($fileName, $fileId){

		$fileDeleted = FALSE; 

		if(unlink(sprintf(public_path('uploads/%s'), $fileName))){
			if(Files::_delete($fileId)){
				$fileDeleted = TRUE; 
			} 
		}

		return $fileDeleted; 
	}	



}
