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

			$checklists=null;
	    	 
	    	return View::make('frontend.checklist.index')
	    				->with('checklists', $checklists)
	    				->with('ownerProjects', $ownerProjects) 
	    				->with('project', $project)
	        			->with('projectDetail', TRUE)
						->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
	    				
	    }

	}

}
