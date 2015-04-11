<?php

class StyleGuideController extends BaseController {

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

	    	 $stylesGuide = array(); 

	    	return View::make('frontend.styleGuide.index')
	    		    	->with('projectName', $project['name'])
	    				->with('projectId', $projectId)
	    				->with('stylesGuide', $stylesGuide)
	    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE); 	    	

	    }

	}

	public function create($projectId){

		// get user role
	    $userRole = Session::get('user_role');
   
	    if($userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	 $project = (array) Project::getName($projectId); 


	    	return View::make('frontend.styleGuide.create')
	    		    	->with('projectName', $project['name'])
	    				->with('projectId', $projectId); 

	    }else{

	    	 return Redirect::to(URL::action('DashboardController@index'));

	    }

	}


}
