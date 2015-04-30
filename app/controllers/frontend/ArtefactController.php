<?php

class ArtefactController extends BaseController {

	public function __construct(){

	      //not user on session
	      $this->beforeFilter(function(){

	        if(is_null(Session::get('user'))){
	          return Redirect::to(URL::action('LoginController@index'));
	        }

	      });
	  }


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

	              	return Redirect::to(URL::action('HeuristicEvaluationController@index', array($projectId)));

	              break;
	              case Config::get('constant.artefact.storm_ideas'):

	              	return Redirect::to(URL::action('StormIdeasController@index', array($projectId)));

	              break;	              
	              case Config::get('constant.artefact.probe'):

	              	return Redirect::to(URL::action('ProbeController@index', array($projectId)));

	              break;
	              case Config::get('constant.artefact.style_guide'):
	              	
	              	return Redirect::to(URL::action('StyleGuideController@index', array($projectId)));

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

	public function getArtefactInfo($artefactId){

		$artefact = (array) Artefact::getById($artefactId); 


	    if(!empty($artefact)){

	      $result = array(
	          'error'  			=> false,
	          'data'			=> $artefact,
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);			

	}


	public function delete($artefactId, $iterationId){

		$artefact = (array) Artefact::getById($artefactId); 


	    if(!empty($artefact)){

	      $result = array(
	          'error'  			=> false,
	          'data'			=> $artefact,
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);			

	}


}
