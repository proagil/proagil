<?php

class StyleGuideController extends BaseController {

	public function __construct(){

	      //not user on session
	      $this->beforeFilter(function(){

	      	 $userRole = Session::get('user_role');

	        if(is_null(Session::get('user'))){
	          return Redirect::to(URL::action('LoginController@index'));
	        }

	      });
	}


	public function index($projectId, $iterationId){

		// get user
		$user = Session::get('user');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 

		if(!$permission){

			 return Redirect::to(URL::action('LoginController@index'));

		}else{			

		    if(is_null(Session::get('user'))){

		          return Redirect::to(URL::action('DashboardController@index'));

		    }else{

		    	//get user role
		    	 $userRole = Session::get('user_role');

		    	 // get project data
		    	 $project = (array) Project::getName($projectId); 
		    	 // get iteration data
		    	 $iteration = (array) Iteration::get($iterationId);	    	 

		    	 $stylesGuide = StyleGuide::enumerate($iterationId);  

		    	return View::make('frontend.styleGuide.index')
		    		    	->with('iteration', $iteration)
		    		    	->with('projectName', $project['name'])
		    				->with('projectId', $projectId)
		    				->with('stylesGuide', $stylesGuide)
		    				->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE); 	    	

		    }
		}
	}

	public function create($projectId, $iterationId){

		// get user
		$user = Session::get('user');
	    $userRole = Session::get('user_role');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){


	    	// get project data
	    	 $project = (array) Project::getName($projectId); 
	    	 // get iteration data
	    	 $iteration = (array) Iteration::get($iterationId);		    	 


	    	return View::make('frontend.styleGuide.create')
	    				->with('iteration', $iteration)
	    		    	->with('projectName', $project['name'])
	    				->with('projectId', $projectId); 

	    }else{

	    	 return Redirect::to(URL::action('LoginController@index'));

	    }

	}

	public function save(){

		$values = Input::get('values');

		// get project data
		$project = (array) Project::getName($values['project_id']);	
		$iterationId = $values['iteration_id'];

       	// get style guide logo
       	$logo = Input::file('logo');

       	// get style guide  interface
       	$interface = Input::file('interface');       	

       	if($logo!=NULL){

       		// save style guide logo
       		$logoId = $this->uploadAndResizeFile($logo, 300, 300); 
       	}

       	if($interface!=NULL){

       		// save style guide interface
       		$interfaceId = $this->uploadAndResizeFile($interface, 700, 700); 
       	}	       			

		$styleGuide = array(
			'name'			=> $values['name'],
			'project_id'	=> $values['project_id'],
			'logo'			=> (isset($logoId))?$logoId:NULL,
			'interface'		=> (isset($interfaceId))?$interfaceId:NULL,
			'iteration_id'  => $iterationId 

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

		   		Session::flash('success_message', 'Se creó la gu&iacute;a de estilos'); 

                // redirect to index probre view
                return Redirect::to(URL::action('StyleGuideController@index', array($values['project_id'], $iterationId)));										

		}else{


		   		Session::flash('error_message', 'No se pudo crear la gu&iacute;a de estilos'); 

		   		return Redirect::to(URL::action('StyleGuideController@index', array($values['project_id'], $iterationId)));			

		}

	}

	public function edit($styleGuideId){
		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($styleGuideId, 'style_guide', $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){ 

			$styleGuide = StyleGuide::getSyleGuideData($styleGuideId);

			// get iteration data
	    	$iteration = (array) Iteration::get($styleGuide['iteration_id']);	

			if(Input::has('_token')){

				$values = Input::get('values');

				// get project data
				$project = (array) Project::getName($values['project_id']);	

		       	// get style guide logo
		       	$logo = Input::file('logo');

		       	// get style guide  interface
		       	$interface = Input::file('interface');       	

		       	if($logo!=NULL){

		       		//delete old interface file
		       		if($styleGuide['logo']!=''){
		       			$this->deleteFile($styleGuide['logo_image'], $styleGuide['logo']); 
		       		}
		       		

		       		// save style guide logo
		       		$logoId = $this->uploadAndResizeFile($logo, 300, 300); 
		       	}

		       	if($interface!=NULL){

		       		//delete old interface file
		       		if($styleGuide['interface']!=''){
		       			$this->deleteFile($styleGuide['interface_image'], $styleGuide['interface']); 
		       		}
		       		
		       		// save style guide interface
		       		$interfaceId = $this->uploadAndResizeFile($interface, 700, 700); 
		       	}

				$styleGuide = array(
					'name'			=> $values['name'],
					'project_id'	=> $values['project_id'],
					'logo'			=> (isset($logoId))?$logoId:$styleGuide['logo'],
					'interface'		=> (isset($interfaceId))?$interfaceId:$styleGuide['interface'],
					'iteration_id'  => $values['iteration_id']

				);

				// update style guide info
				StyleGuide::_update($values['style_guide_id'], $styleGuide);

				// save primary colors
				if(isset($values['primary_color'])){

					// delete old primary colors
					if (StyleGuide::deletePrimaryColors($values['style_guide_id'])){

						foreach($values['primary_color'] as $color){

							$primaryColor = array(
								'hexadecimal'		=> $color,
								'type'				=> Config::get('constant.style_guide.color.primary'),
								'style_guide_id'	=> $values['style_guide_id']
							);

							$primaryColorId = StyleGuide::saveColor($primaryColor);

						}					
					}

				}

				// save secundary colors
				if(isset($values['secundary_color'])){

					// delete old secundary colors
					if(StyleGuide::deleteSecundaryColors($values['style_guide_id'])){

						foreach($values['secundary_color'] as $color){

							$secundaryColor = array(
								'hexadecimal'		=> $color,
								'type'				=> Config::get('constant.style_guide.color.secundary'),
								'style_guide_id'	=> $values['style_guide_id']
							);

							$secundaryColorId = StyleGuide::saveColor($secundaryColor);

						}
					}				
					
				}

				// save fonts values
				if(isset($values['font_name'])){

					// delete old fonts
					StyleGuide::deleteFonts($values['style_guide_id']);

					foreach($values['font_name'] as $index => $font){

						$fontValue = array(
							'name'				=> $font,
							'size'				=> $values['font_size'][$index],
							'style_guide_id'	=> $styleGuideId
						);

						$secundaryColorId = StyleGuide::saveFont($fontValue);

					}				
					
				}

				Session::flash('success_message', 'Se editó la gu&iacute;a de estilos'); 

		        // redirect to index style guide view
		        return Redirect::to(URL::action('StyleGuideController@index', array($values['project_id'], $iteration['id'])));										

			
			}else{

				if(!empty($styleGuide)){

					// get project data
					 $project = (array) Project::getName($styleGuide['project_id']); 


					return View::make('frontend.styleGuide.edit')
								->with('values', $styleGuide)
								->with('iteration', $iteration)
								->with('projectName', $project['name'])
								->with('projectId', $project['id'])
								->with('styleGuideId', $styleGuideId);   			

				}else{

					return Redirect::to(URL::action('DashboardController@index'));

				}
			}
		}else{

			return Redirect::to(URL::action('LoginController@index'));

		}

	}

	public function deleteColor($colorId) {

		 if(StyleGuide::deleteColor($colorId)) {

		      $result = array(
		          'error'   => false
		      );		 	

		 }else{

		      $result = array(
		          'error'     => true
		      );		 	

		 } 

	      header('Content-Type: application/json');
	      return Response::json($result);			 

	}		

	public function deleteFont($fontId) {

		 if(StyleGuide::deleteFont($fontId)) {

		      $result = array(
		          'error'   => false
		      );		 	

		 }else{

		      $result = array(
		          'error'     => true
		      );		 	

		 } 

	      header('Content-Type: application/json');
	      return Response::json($result);			 

	}	

	function detail($styleGuideId){
		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($styleGuideId, 'style_guide', $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){ 


			$styleGuide = StyleGuide::getSyleGuideData($styleGuideId);	

				if(!empty($styleGuide)){

					 $project = (array) Project::getName($styleGuide['project_id']); 
					// get iteration data
			    	$iteration = (array) Iteration::get($styleGuide['iteration_id']);					 


					return View::make('frontend.styleGuide.detail')
								->with('iteration', $iteration)
								->with('projectName', $project['name'])
								->with('projectId', $project['id'])
								->with('styleGuide', $styleGuide)
								->with('styleGuideId', $styleGuideId);   			

				}else{

					return Redirect::to(URL::action('DashboardController@index'));

				}		
		}else{

			return Redirect::to(URL::action('LoginController@index'));

		}					

	}	

	function export($styleGuideId){

		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($styleGuideId, 'style_guide', $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){ 


			$styleGuide = StyleGuide::getSyleGuideData($styleGuideId);	

			if(!empty($styleGuide)){


				 $project = (array) Project::getName($styleGuide['project_id']); 

		        $pdf = PDF::loadView('frontend.styleGuide.export', $styleGuide);

		        return $pdf->download('proagil-'.$styleGuide['name'].'.pdf');						 

			}else{

				return Redirect::to(URL::action('DashboardController@index'));

			}		
		}else{

			return Redirect::to(URL::action('LoginController@index'));

		}					

	}	


	public function deleteStyleGuide($styleGuideId){
		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($styleGuideId, 'style_guide', $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){ 


			$styleGuide = StyleGuide::getSyleGuideData($styleGuideId);	

				if(!empty($styleGuide)){

					if(StyleGuide::deleteStyleGuide($styleGuideId)){

						//delete files
						if($styleGuide['logo']!= ''){
							$this->deleteFile($styleGuide['logo_image'], $styleGuide['logo']); 
						}

						if($styleGuide['interface']!= ''){
							$this->deleteFile($styleGuide['interface_logo'], $styleGuide['interface']); 
						}
											

						Session::flash('success_message', 'Se ha eliminado la gu&iacute;a de estilos correctamente'); 

			   			return Redirect::to(URL::action('StyleGuideController@index', array($styleGuide['project_id'], $styleGuide['iteration_id'])));					

					}else{

			   			Session::flash('error_message', 'No se ha podido eliminar la gu&iacute;a de estilos'); 

			   			return Redirect::to(URL::action('StyleGuideController@index', array($styleGuide['project_id'], $styleGuide['iteration_id'])));							

					}


				}else{

					return Redirect::to(URL::action('DashboardController@index'));

				}	
		}else{

			return Redirect::to(URL::action('LoginController@index'));

		}	

	}

	public function uploadAndResizeFile($file, $width, $height) {

		// get client name and generate server name
		$clientName = $file->getClientOriginalName(); 
		$serverName = md5(time(). str_replace(' ', '_', $clientName)).'.'.$file->guessClientExtension();

		// move file into uploads folder and resize
		$file->move(public_path('uploads'), $serverName);
		$resizedFile = Image::make(sprintf(public_path('uploads/%s'), $serverName))->widen($width)->save();

		// save image on database and generate file id
		if($resizedFile!=NULL){

			$fileValues = array(
				'client_name'		=> $clientName,
				'server_name'		=> $serverName 
			);

			return $fileId = Files::insert($fileValues); 
		}	

	}

	public function deleteFile($fileName, $fileId){

		$fileDeleted = FALSE; 

		if(unlink(sprintf(public_path('uploads/%s'), $fileName))){
			if(Files::_delete($fileId)){
				$fileDeleted = TRUE; 
			} 
		}

		return $fileDeleted; 
	}		


}
