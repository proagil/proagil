<?php

class IterationController extends BaseController {

 	public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        if(is_null(Session::get('user'))){
          return Redirect::to(URL::action('LoginController@index'));
        }

      });
 	}	

	public function config($projectId) {

    //get project iterations

    $projectIterations = Iteration::getIterationsByProject($projectId); 



	}

}
