<?php

class ProbeController extends BaseController {

	public function index($projectId){

	    if(is_null(Session::get('user'))){

	          return Redirect::to(URL::action('DashboardController@index'));

	    }else{

	    	//get user role
	    	 $userRole = Session::get('user_role');

	    	 // get project data
	    	 $project = (array) Project::getName($projectId); 

	    	return View::make('frontend.probe.index')
	    				->with('projectName', $project['name'])
	    				->with('projectId', $projectId)
	    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);

	    }

	}

	public function create($projectId){

		// get user role
	    $userRole = Session::get('user_role');

	    if($userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	 $project = (array) Project::getName($projectId); 

	    	 // get answer types
	    	 $types = Probe::getAnswerTypes(); 

	    	return View::make('frontend.probe.create')
	    		    	->with('projectName', $project['name'])
	    		    	->with('answerTypes', $types)
	    				->with('projectId', $projectId); 

	    }else{

	    	 return Redirect::to(URL::action('DashboardController@index'));

	    }
	}

	public function save(){
		   $values = Input::get('probe');

		   print_r($values); die; 
	}


}
