<?php

class ActivityController extends BaseController {

	public function __construct(){

	      //not user on session
	      $this->beforeFilter(function(){

	        if(is_null(Session::get('user'))){
	          return Redirect::to(URL::action('LoginController@index'));
	        }

	      });
	}	


	public function create($projectId, $iterationId) {
		//get user
	    $user = Session::get('user');
    	$userRole = (array) User::getUserRoleOnIteration($iterationId, $user['id']);

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']);    
		
    	if(empty($userRole) || !$permission){

      		return Redirect::to(URL::action('DashboardController@index')); 	

      	}else{	 	

		    //get user On iteration
		    $users =  array('0' => 'Seleccione un usuario'); 
		    $usersOnIteration = (array) Project::getAllUsersOnIteration($iterationId);
		    $usersOnIteration = $users+$usersOnIteration; 

			//get categories On project
			$typeCategories = array('0' => 'Seleccione una categoría');
	    	$categories = (array) ActivityCategory::getCategoriesByProjectId($projectId);

	    	$iteration = (array) Iteration::get($iterationId);

	    	if (!empty($categories)){
	    		$categories = $typeCategories+$categories;
	    	} 		

	    	$project = (array) Project::get($projectId);

			if(Input::has('_token')){
				
				// validation rules
		        $rules =  array(
			        'title'									=> 'required',
			        'start_date'							=> 'required|date_format:"d-m-Y"',
			        'closing_date'							=> 'required|date_format:"d-m-Y"|after:start_date',
		            'description'							=> 'required',
		            'assigned_user_id'						=> 'integer|min:1'
		        );

		        $message =  array(
			        'after'			=> 'La fecha fin debe ser mayor a la fecha inicio'
		        );
		        // set validation rules to input values
		        $validator = Validator::make(Input::get('values'), $rules, $message);


		        // get input valiues
		        $values = Input::get('values');

		        if(!$validator->fails()){

			        // $nowDate = (array) new DateTime('today');

			        $activity = array(
		                'title'      	    						=> $values['title'],
		                'description'       						=> $values['description'],
						'enabled'           						=> Config::get('constant.ENABLED'),
		                'status'   									=> Config::get('constant.activity.not_initiated'),
		                'category_id'   							=> (isset($values['category_id']))?$values['category_id']:null,
		                'start_date'								=> $values['start_date'],
		                'closing_date'     							=> $values['closing_date']
		            );

		            // insert activity on DB
		            $activityId = Activity::insert($activity);

		            if($activityId>0) {

		            	$assignedUserId = isset($values['assigned_user_id'])$values['assigned_user_id']:NULL;


				        $projectActivity = array(
				            'project_id'    => $projectId,
				            'activity_id'   => $activityId,
				            'user_id'		=> $assignedUserId,
				            'iteration_id'  => $iterationId 
				        );
				
						//save project activity
			            Activity::insertProjectActivity($projectActivity); 

			            $assignedUser = (array) User::getUserById($assignedUserId);

		                $emailData = array(
			                'assigned_user_name'     		=> $assignedUser['first_name'],
			                'activity_title'     			=> $values['title'],
			                'iteration_name'				=> $iteration['name'],
		                	'user_name'     				=> $user['first_name'],
			                'url_token'     				=> URL::to('/'). '/proyecto/detalle/'. $projectId . '/'. $iterationId 
			            );

						$email = $assignedUser['email'];

		                // send email with assigned activity
		                Mail::send('frontend.email_templates.assignedUserActivity', 

		                $emailData, 

		                function($message) use ($email){

		                  $message->to($email);
		                  $message->subject('PROAGIL: Notificación de actividad asignada');
		                });  
						Session::flash('success_message', 'Se ha creado la actividad: '.$activity['title']); 
						return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId. '/'. $iterationId);
	                
	                }

			    }else{

	              	return View::make('frontend.activity.create')
	                        ->with('categories', $categories)
	                        ->with('iteration', $iteration)
			        		->with('project', $project)
			        		->with('projectDetail', TRUE)
			        		->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
			        		->with('usersOnIteration',$usersOnIteration)
			        		->withErrors($validator)
	                        ->with('values', $values);
			    }			

			}else{

		        // render view first time 
		        return View::make('frontend.activity.create') 
		        		->with('categories', $categories)
		        		->with('iteration', $iteration)
		        		->with('project', $project)
		        		->with('projectDetail', TRUE)
		        		->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
		        		->with('usersOnIteration',$usersOnIteration);
		    }

		}
		

	}

	public function edit($activityId){

		//get user
	    $user = Session::get('user');

		$permission = User::userHasPermissionOnActivity($activityId, 'activity_belongs_to_project', $user['id']); 

		if(!$permission){

			return Redirect::to(URL::action('DashboardController@index')); 

		}else{

			$activity = (array) Activity::get($activityId);

			$iterationId = $activity['iteration_id'];
			
			$iteration = (array) Iteration::get($iterationId);

			$projectId = $activity['project_id'];

			//get user
		    $user = Session::get('user');
	    	$userRole = (array) User::getUserRoleOnIteration($iterationId, $user['id']);

		    //get user On iteration
		    $usersOnIteration = (array) Project::getUsersOnIteration($iterationId);

			//get categories On project
			$typeCategories = array('0' => 'Seleccione una categoria');
	    	$categories = (array) ActivityCategory::getAllCategoriesByProjectId($projectId);

	    	if (!empty($categories)){
	    		$categories = $typeCategories+$categories;
	    	} 

			//get project information
	    	$project = (array) Project::get($projectId);

			if(Input::has('_token')){
				
				// validation rules
		        $rules =  array(
			        'title'									=> 'required',
			        'start_date'							=> 'required|date_format:"d-m-Y"',
			        'closing_date'							=> 'required|date_format:"d-m-Y"|after:start_date',
		            'description'							=> 'required',
		            'assigned_user_id'						=> 'integer|min:1'
		        );

		        $message =  array(
			        'after'			=> 'La fecha fin debe ser mayor a la fecha inicio'
		        );
		        // set validation rules to input values
		        $validator = Validator::make(Input::get('values'), $rules, $message);

		        // get input valiues
		        $values = Input::get('values');

		        if(!$validator->fails()){

			        $nowDate = (array) new DateTime('today');

			        $updateActivity = array(
		                'title'      	    	=> $values['title'],
		                'description'       	=> $values['description'],
		                'category_id'   		=> (isset($values['category_id']))?$values['category_id']:null,
		                'start_date'     		=> $values['start_date'],
		                'closing_date'     		=> $values['closing_date']
		            );

		            // insert activity on DB
		            $updateActivity = Activity::updateActivity($activityId,$updateActivity);

		            if($updateActivity) {

		            	$assignedUserId = $values['assigned_user_id'];
		            	if($assignedUserId != $activity['user_id']){

					        $updateProjectActivity = array(
					            'user_id'		=> $assignedUserId 
					        );

							$abtpId = $activity['abtp_id'];

							//save project activity
				            Activity::updateProjectActivity($abtpId, $updateProjectActivity); 

				            $assignedUser = (array) User::getUserById($assignedUserId);


							$emailData = array(
				                'assigned_user_name'     		=> $assignedUser['first_name'],
				                'activity_title'     			=> $values['title'],
				                'iteration_name'				=> $iteration['name'],
			                	'user_name'     				=> $user['first_name'],
				                'url_token'     				=> URL::to('/'). '/proyecto/detalle/'. $projectId . '/'. $iterationId 
				            );

							$email = $assignedUser['email'];

			                // send email with assigned activity
			                Mail::send('frontend.email_templates.assignedUserActivity', 

			                $emailData, 

			                function($message) use ($email){

			                  $message->to($email);
			                  $message->subject('PROAGIL: Notificación de actividad asignada');
			                });  
			            }

						Session::flash('success_message', 'Se ha editó la actividad: '.$values['title']); 
						return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId. '/'. $iterationId);                
	                	
	                }

			    }else{
					
	              	return View::make('frontend.activity.edit')
	              			->with('activityId', $activityId)
	                        ->with('categories', $categories)
			        		->with('project', $project)
			        		->with('projectDetail', TRUE)
			        		->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
			        		->with('usersOnIteration',$usersOnIteration)
			        		->withErrors($validator)
	                        ->with('values', $values);
			    }			

			}else{
				$values = $activity;

				$date = new DateTime($values['start_date']);
				$values['start_date']	= $date->format('d-m-Y');

				$date = new DateTime($values['closing_date']);
				$values['closing_date']	= $date->format('d-m-Y');
			        	
		        // render view first time 
		        return View::make('frontend.activity.edit') 
		        		->with('activityId', $activityId)	        		
		        		->with('categories', $categories)
		        		->with('project', $project)
		        		->with('projectDetail', TRUE)
		        		->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
		        		->with('usersOnIteration',$usersOnIteration)
		        		->with('values', $values);
		    }

		}
		
	}


	public function delete($activityId){

		//get user
	    $user = Session::get('user');		

		$permission = User::userHasPermissionOnActivity($activityId, 'activity_belongs_to_project', $user['id']); 

		if(!$permission){

			return Redirect::to(URL::action('DashboardController@index')); 

		}else{

			$activity = (array) Activity::getById($activityId);

			$projectId = $activity['project_id'];

			$iterationId = $activity['iteration_id'];

			$deleteCommets = Activity::deleteActivityComment($activityId);

			$deleteIterationActivity = Activity::deleteIterationActivity($activityId, $iterationId);

			if($deleteIterationActivity){

				$deleteActivity = (array) Activity::deleteActivity($activityId);
				if($deleteActivity){

					Session::flash('success_message', 'Se ha eliminado la actividad: '.$activity['title']); 
					return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId . '/' . $iterationId );
				}else{
					
					Session::flash('error_message', 'Ocurrió un problema al eliminar la actividad'.$activity['title']); 
					return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId . '/' . $iterationId );
				}

			}else{
					
				Session::flash('error_message', 'Ocurrió un problema al eliminar la actividad'.$activity['title']); 
				return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId . '/' . $iterationId );
			}
		}

	}

	public function detail($activityId){
		// get user on session
        $user = Session::get('user');

        // get activity data
		$activity = (array) Activity::get($activityId); 
		$activity['closing_date'] = date('d/m/Y', strtotime($activity['closing_date']));

		switch($activity['status']){
			case 1:
				$activity['status_name'] = 'Asignada';
				break; 
			case 2:
				$activity['status_name'] = 'Iniciada';
				break; 			
			case 3:
				$activity['status_name'] = 'Terminada';
				break; 			
		}

		// get activity comments
		$comments = Activity::getComments($activityId); 

		//format comments date and add flag to know comment autor
		foreach($comments as $index => $comment){
			$comments[$index]['date'] = date('d/m/Y', strtotime($comments[$index]['date']));

			($user['id']==$comment['user_id'])?$comments[$index]['editable'] = TRUE:$comments[$index]['editable'] = FALSE; 
		}

		return View::make('frontend.activity.detail')
					->with('activity', $activity)
					->with('comments', $comments); 

	}

	public function commnet() {

		// get user on session
        $user = Session::get('user');

		 $values = Input::get('values');

		 $comment = array(
		 	'comment'		=> $values['comment'],
		 	'date'			=> date('Y-m-d'),
		 	'user_id'		=> $user['id'],
		 	'activity_id'	=> $values['activity_id']
		 );

		 $commentId = Activity::saveComment($comment);

		 if($commentId>0){

		 	$insertedComment = Activity::getComment($commentId); 

		 	$insertedComment['date'] = date('d/m/Y', strtotime($insertedComment['date']));

			($user['id']==$insertedComment['user_id'])?$insertedComment['editable'] = true:$insertedComment['editable'] = false;

			 $result = array(
			 	'error'			=> false,
			 	'comment'		=> $insertedComment,
			 	'user'			=> $user
			 ); 

		 }else{

			 $result = array(
			 	'error'			=> true
			 ); 		 	

		 }

	     header('Content-Type: application/json');
	     return Response::json($result);

	}

	public function deleteComment($commentId){

	    if(Activity::deleteComment($commentId)){

	      $result = array(
	          'error'       => false
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);

	}

	public function changeStatus($activityId, $statusId){

	    $values = array(
	      'status'    => $statusId
	    );

	    if(Project::updateActivity($activityId, $values)){

	      $result = array(
	          'error'       => false,
	          'new_status'  => $statusId
	      );

	    }else{

	      $result = array(
	          'error'     => true
	      );

	    }
	      header('Content-Type: application/json');
	      return Response::json($result);

	}

	public function reassign($activityId) {

		$user = Session::get('user');

		$activityInformation = (array) Activity::getActivityUserAndProject($activityId);

		$iterationId = $activityInformation['iteration_id'];
		
		$iteration = (array) Iteration::get($iterationId);

		$projectId = $activityInformation['project_id'];

		$abtpId = $activityInformation['abtp_id'];

		if(Input::has('_token')){
		
			// validation rules
	        $rules =  array(
	            'assigned_user_id'		=> 'integer|min:1'
	        );

	        // set validation rules to input values
	        $validator = Validator::make(Input::get('values'), $rules);

	        // get input valiues
	        $values = Input::get('values');

	        if(!$validator->fails()){

	        	$assignedUserId = $values['assigned_user_id'];

		        $updateProjectActivity = array(
		            'user_id'		=> $assignedUserId 
		        );

				if($assignedUserId != $activityInformation['user_id']){
					//save project activity

		        	Activity::updateProjectActivity($abtpId, $updateProjectActivity);
		        	$assignedUser = (array) User::getUserById($assignedUserId);
				}else{
					$assignedUser = $activityInformation;
				}


		        $emailData = array(
	                'assigned_user_name'     		=> $assignedUser['first_name'],
	                'activity_title'     			=> $activityInformation['title'],
	                'iteration_name'				=> $iteration['name'],
                	'user_name'     				=> $user['first_name'],
	                'url_token'     				=> URL::to('/'). '/proyecto/detalle/'. $projectId . '/'. $iterationId 
	            );

				$email = $assignedUser['email'];

                // send email with assigned activity
                Mail::send('frontend.email_templates.assignedUserActivity', 

                $emailData, 

                function($message) use ($email){

                  $message->to($email);
                  $message->subject('PROAGIL: Notificación de actividad asignada');
                });  

				Session::flash('success_message', 'Se ha reasignado la actividad: '.$activityInformation['title']); 
				
				return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId. '/'. $iterationId);
			}else{
				Session::flash('error_message', 'Ocurrió un problema al reasignar la actividad'); 

                // redirect to detail view
                return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId);

			}
		
		}else{
			Session::flash('error_message', 'Ocurrió un problema al reasignar la actividad'); 

            // redirect to detail
            return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId);

		}

	}	


}
