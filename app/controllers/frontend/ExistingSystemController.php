<?php

class ExistingSystemController extends BaseController {

	public function index(){

    if(!is_null(Session::get('user'))){

          return Redirect::to(URL::action('DashboardController@index'));

    }else{

    }

	}


}
