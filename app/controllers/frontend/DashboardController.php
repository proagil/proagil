<?php

class DashboardController extends BaseController {

 	public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        if(is_null(Session::get('user'))){
          return Redirect::to(URL::action('LoginController@index'));
        }

      });
 	}	

	public function index(){

		$sessionUser = Session::get('user');

		// get owner and member projects
		$ownerProjects = Project::getOwnerProjects($sessionUser['id']);

		$memberProjects = Project::getMemberProjects($sessionUser['id']);

   		return View::make('frontend.dashboard.index')
   				->with('ownerProjects', $ownerProjects)
   				->with('memberProjects', $memberProjects); 

	}

}
