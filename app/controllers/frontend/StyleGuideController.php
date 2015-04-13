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

	    	 $stylesGuide = StyleGuide::enumerate($projectId);  

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

	public function save(){

		$values = Input::get('values');

		//print_r(	$values); die; 

		// get project data
		$project = (array) Project::getName($values['project_id']);	

		$styleGuide = array(
			'name'			=> $values['name'],
			'project_id'	=> $values['project_id']

		);

		$styleGuideId = StyleGuide::insert($styleGuide);

		if($styleGuideId>0){

			// save primary colors
			if(isset($values['primary_color'])){

				foreach($values['primary_color'] as $color){

					$primaryColor = array(
						'hexadecimal'		=> $color,
						'type'				=> Config::get('constant.style_guide.color.primary'),
						'style_guide_id'	=> $styleGuideId
					);

					$primaryColorId = StyleGuide::saveColor($primaryColor);

				}

			}

			// save secundary colors
			if(isset($values['secundary_color'])){

				foreach($values['secundary_color'] as $color){

					$secundaryColor = array(
						'hexadecimal'		=> $color,
						'type'				=> Config::get('constant.style_guide.color.secundary'),
						'style_guide_id'	=> $styleGuideId
					);

					$secundaryColorId = StyleGuide::saveColor($secundaryColor);

				}				
				
			}

			// save fonts values
			if(isset($values['font_name'])){

				foreach($values['font_name'] as $index => $font){

					$fontValue = array(
						'name'				=> $font,
						'size'				=> $values['font_size'][$index],
						'style_guide_id'	=> $styleGuideId
					);

					$secundaryColorId = StyleGuide::saveFont($fontValue);

				}				
				
			}

		   		Session::flash('success_message', 'Se ha creado la gu&iacute;a de estilos exitosamente en su proyecto: '.$project['name']); 

                // redirect to index probre view
                return Redirect::to(URL::action('StyleGuideController@index', array($values['project_id'])));										

		}else{


		   		Session::flash('error_message', 'No se ha podido crear la gu&iacute;a de estilos en su proyecto: '.$project['name']); 

		   		return Redirect::to(URL::action('StyleGuideController@index', array($values['project_id'])));			

		}

	}

	public function edit(){

	}


}
