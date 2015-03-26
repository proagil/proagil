<?php

class ChecklistController extends BaseController {

	public function index($projectId){

	    if(is_null(Session::get('user'))){

	          return Redirect::to(URL::action('DashboardController@index'));

	    }else{
	    	$user = Session::get('user');
	    	$userRole = Session::get('user_role');
	    	
	    	 // get project data
	    	$project = (array) Project::getName($projectId); 

	    	// project list on sidebar
	        $ownerProjects = Project::getOwnerProjects($user['id']);
	        $ownerProjects = (count($ownerProjects)>=6)?array_slice($ownerProjects, 0, 6):$ownerProjects;

			$checklists = (array) Checklist::enumerate($projectId);
	    	 
	    	return View::make('frontend.checklist.index')
	    				->with('checklists', $checklists)
	    				->with('ownerProjects', $ownerProjects) 
	    				->with('project', $project)
	        			->with('projectDetail', TRUE)
						->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
	    				
	    }

	}
		public function edit($checklistId){

/*		$probeData = Probe::getProbeElements($probeId); 

		//print_r($probeData ); die; 


		if(!empty($probeData)){

			// get project data
		   	$project = (array) Project::getName($probeData['project_id']);

		   	//probe status
		   	$probeStatus = array(
		   		'1'			=> 'Cerrado',
		   		'2'			=> 'Abierto'
		   	);

	    	 // get answer types
	    	 $answerTypes = Probe::getAnswerTypes(); 	  	 

			return View::make('frontend.probe.edit')
						->with('projectName', $project['name'])
						->with('probeId', $probeId)
						->with('answerTypes', $answerTypes)
						->with('values', $probeData)
						->with('probeStatus', $probeStatus); 			

		}else{

		}*/

	}

}
