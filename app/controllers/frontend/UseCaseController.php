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

	public function saveDiagram(){


		$diagramValues = Input::all();   
		print_r($diagramValues); die; 

		return View::make('frontend.diagrams.use_case.show');
		//header('Content-Type: application/json');
	    // return Response::json($result);die; 
		/*$query= DB::table('use_diagram')->where('id_project', '$id');
		$diagram = Input::get('jsonString');

		if (is_null ($query)){

			$usediagram = new $use_diagram();
			$usediagram->id_project = $id;
			$usediagram->diagrama = $diagram;

			$usediagram->save();
			
			


		}else{

			$row = use_diagram::where('id_project', '$id')->update(diagrama => $diagram);



		}
		



		header('Content-Type: application/json');
	     return Response::json($result);	

	}
*/
}
}
