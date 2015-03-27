<?php

class ExistingSystemController extends BaseController {

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
		   		Session::flash('success_message', 'Se ha creado el analisis de sistema existente exitosamente en su proyecto: '.$project['name']); 

                // redirect to index probre view
                return Redirect::to(URL::action('ExistingSystemController@index', array($values['project_id'])));			

		}else{

		   		Session::flash('error_message', 'No se ha podido crear el analisis de sistema existente en su proyecto: '.$project['name']); 

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
						->with('topics', $topics)
						->with('existingSystemId', $existingSystemId);   			

		}else{

			return Redirect::to(URL::action('DashboardController@index'));

		}		

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
		$resizedFile = Image::make(sprintf(public_path('uploads/%s'), $serverName))->resize($width, $height)->save();

		// save image on database and generate file id
		if($resizedFile!=NULL){

			$fileValues = array(
				'client_name'		=> $clientName,
				'server_name'		=> $serverName 
			);

			return $fileId = Files::insert($fileValues); 
		}

	}



}
