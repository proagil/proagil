<?php

class ArtefactController extends BaseController {

	public function index(){

	    if(!is_null(Session::get('user'))){

	          return Redirect::to(URL::action('DashboardController@index'));

	    }else{

	   	}

	}

	public function detail($friendlyUrl, $projectId){

		$artefact = Artefact::getByFriendlyUrl($friendlyUrl);


		if(!empty($artefact)){

			switch($friendlyUrl) {
	              case Config::get('constant.artefact.heuristic_evaluation'):

	              	echo 'heuristic_evaluation';

	              break;
	              case Config::get('constant.artefact.storm_ideas'):

	              	return Redirect::to(URL::action('StormIdeasController@index', array($projectId)));

	              break;	              
	              case Config::get('constant.artefact.probe'):

	              	return Redirect::to(URL::action('ProbeController@index', array($projectId)));

	              break;
	              case Config::get('constant.artefact.style_guide'):

	              	echo 'style_guide'; 

	              break;
	              case Config::get('constant.artefact.existing_system'):

	              return Redirect::to(URL::action('ExistingSystemController@index', array($projectId)));

	              break;
	              case Config::get('constant.artefact.checklist'):

	              	return Redirect::to(URL::action('ChecklistController@index', array($projectId)));

	              break;
	              case Config::get('constant.artefact.use_case'):

	              	return Redirect::to(URL::action('UseCaseController@index', array($projectId)));

	              break;	       	              	              
	        }


		}else{
			return Redirect::to(URL::action('LoginController@index'));
		}


	}


}
