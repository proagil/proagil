<?php

class AdminDashboardController extends AdminBaseController {

	public function __construct(){

	    //not user on session
	    $this->beforeFilter(function()
	        {
	      if(is_null(Session::get('admin_user'))){

	        return Redirect::to(URL::action('AdminLoginController@index'));
	      }
	        });
	}	

	public function index(){

      return View::make('admin.dashboard.index');

	}

}
