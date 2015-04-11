<?php

class StormIdeasController extends BaseController {

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

	    	$user = Session::get('user');
	    	$userRole = Session::get('user_role');
	    	
	    	 // get project data
	    	$project = (array) Project::getName($projectId); 

			$stormsIdeas = (array) StormIdeas::enumerate($projectId);
	    	 
	    	return View::make('frontend.stormIdeas.index')
	    				->with('stormsIdeas', $stormsIdeas)
	    				->with('project', $project)
	        			->with('projectDetail', TRUE)
						->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);	    	
	    }

	}

	public function create($projectId){

		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    if($userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	$project = (array) Project::getName($projectId); 

	    	
	        if(Input::has('_token')){

		        // get input valiues
		        $values = Input::get('values');	 
	            	
            	$rules =  array(
		          'name'       		=> 'required',
		          'ideas' 			=> 'required'
	        	);

	            // set validation rules to input values
		        $validator = Validator::make(Input::get('values'), $rules);

		        if(!$validator->fails()){

		        	$ideas = $values['ideas'];

		        	$words = preg_split("/[\s,]+/", $ideas);

		        	$countWords = array_count_values($words);

		        	$stormIdeas = array(
	                  'enabled'        		=> Config::get('constant.ENABLED'),
	                  'project_id'          => $projectId,
	                  'name'             	=> $values['name'],
	                  'ideas'				=> $ideas
	                );

	                // insert checklist on DB
              		$stormIdeasId = StormIdeas::insert($stormIdeas);  

              		if($stormIdeasId>0) {

              			$stormIdeasWords = array(); 

	                	foreach($countWords as $index => $countWord){

	                		if($index!=''){
	                			$stormIdeasWord = array(
			                    	'word'      			=> $index,
			                      	'storm_ideas_id'       	=> $stormIdeasId,
			                        'weight'     			=> $countWord,
			                	);
			                	array_push($stormIdeasWords, $stormIdeasWord);
			                	// $stormIdeasWordId = StormIdeas::insertStormIdeasWord($stormIdeasWord); 
	                		}

	                  	}

                 		return View::make('frontend.stormIdeas.show')
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
						    	->with('stormIdeas', $stormIdeas)
						    	->with('stormIdeasId', $stormIdeasId)
                          		->with('stormIdeasWords', $stormIdeasWords);

		            }else{

                 		return View::make('frontend.stormIdeas.create')
                              	->with('error_message', 'No se pudo crear la tormenta de ideas')
                              	->with('values', $values)
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
              		}

		        }else{

              		return View::make('frontend.stormIdeas.create')
	                          	->withErrors($validator)
	                          	->with('values', $values)
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);

           		} 
		    }else{

	         	// render view first time 
		        return View::make('frontend.stormIdeas.create')
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
		    }
		}else{

			return Redirect::to(URL::action('DashboardController@index'));
		}
	}


	public function edit($stormIdeasId){

		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    if($userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	$stormIdeas = (array) StormIdeas::get($stormIdeasId);
	    	$projectId = $stormIdeas['project_id'];
	    	$project = (array) Project::getName($projectId);

	    	$values = $stormIdeas;
	    	
	        if(Input::has('_token')){

		        // get input valiues
		        $values = Input::get('values');	 
	            	
            	$rules =  array(
		          'name'       		=> 'required',
		          'ideas' 			=> 'required'
	        	);

	            // set validation rules to input values
		        $validator = Validator::make(Input::get('values'), $rules);

		        if(!$validator->fails()){

		        	$ideas = $values['ideas'];

		        	$words = preg_split("/[\s,]+/", $ideas);

/*		        	echo "<pre>";
		        	print_r($words);
		        	echo "</pre>";*/

		        	$countWords = array_count_values($words);

		        	$stormIdeas = array(
	                  'enabled'        		=> Config::get('constant.ENABLED'),
	                  'project_id'          => $projectId,
	                  'name'             	=> $values['name'],
	                  'ideas'				=> $ideas
	                );

	                // insert checklist on DB
              		$updateStormIdeasId = StormIdeas::updateStormIdeas($stormIdeasId, $stormIdeas);  

              		if($updateStormIdeasId>0) {
              			$stormIdeasWords = array(); 

	                	foreach($countWords as $index => $countWord){

	                		if($index!=''){
	                			$stormIdeasWord = array(
			                    	'word'      			=> $index,
			                      	'storm_ideas_id'       	=> $stormIdeasId,
			                        'weight'     			=> $countWord,
			                	);
			                	array_push($stormIdeasWords, $stormIdeasWord);
	                		}

	                  	}

                 		return View::make('frontend.stormIdeas.show')
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
						    	->with('stormIdeas', $stormIdeas)
						    	->with('stormIdeasId', $stormIdeasId)
                          		->with('stormIdeasWords', $stormIdeasWords);

		            }else{

                 		return View::make('frontend.stormIdeas.edit')
                              	->with('error_message', 'No se pudo editar la tormenta de ideas')
                              	->with('values', $values)
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
              		}

		        }else{

              		return View::make('frontend.stormIdeas.edit')
	                          	->withErrors($validator)
	                          	->with('values', $values)
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);

           		} 
		    }else{

	         	// render view first time 
		        return View::make('frontend.stormIdeas.edit')
		        				->with('values', $values)
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
		    }
		}else{

			return Redirect::to(URL::action('DashboardController@index'));
		}
	}

	public function show($stormIdeasId){
		echo "show";
		return true;
	}

	public function saveStormIdeasImage($stormIdeasId,$stormIdeasName){

		$img = $_POST['imgBase64'];
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);

		// get client name and generate server name
	    $clientName = $stormIdeasName; 
	    $serverName = md5(time(). str_replace(' ', '_', $clientName));

	    //save image into uploaps folder
	    $success = file_put_contents(public_path('uploads') . '/'.$serverName .'.png', $data);

	    // save image on database and generate file id
	    if($success){
		    $fileValues = array(
		      'client_name'   => $clientName .'.png',
		      'server_name'   => $serverName .'.png'
		    );
      		$stormIdeasImageId = AdminFiles::insert($fileValues);

			$stormIdeas = array(
              'image'				=> $stormIdeasImageId
            );
            // insert checklist on DB
      		$stormIdeasId = StormIdeas::updateStormIdeas($stormIdeasId, $stormIdeas); 
      	}

	}



}
