<?php

class UseCaseController extends BaseController {

	public function index($projectId){

	    if(is_null(Session::get('user'))){

	          return Redirect::to(URL::action('DashboardController@index'));

	    }else{

	    	$userRole = Session::get('user_role');

	    	 // get project data
	    	 $project = (array) Project::getName($projectId); 

	    	 
	    	return View::make('frontend.diagrams.use_case.index')
						->with('projectName', $project['name'])
						->with('projectId', $projectId)
						->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
	    				

	   	}

	}


}
