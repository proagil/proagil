<?php

class ChecklistController extends BaseController {

	public function __construct(){

	      //not user on session
	      $this->beforeFilter(function(){

	        if(is_null(Session::get('user'))){
	          return Redirect::to(URL::action('LoginController@index'));
	        }

	      });
	  }


	public function index($projectId, $iterationId){

		$user = Session::get('user');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 

		if(!$permission){

			 return Redirect::to(URL::action('LoginController@index'));

		}else{

		    if(is_null(Session::get('user'))){

		        return Redirect::to(URL::action('DashboardController@index'));

		    }else{

		    	$user = Session::get('user');
		    	$userRole = Session::get('user_role');
		    	
		    	 // get project data
		    	$project = (array) Project::getName($projectId); 

		    	$iteration = (array) Iteration::get($iterationId); 

				$checklists = (array) Checklist::enumerate($iterationId);

		    	 
		    	return View::make('frontend.checklist.index')
		    				->with('checklists', $checklists)
		    				->with('iteration', $iteration)
		    				->with('project', $project)
		        			->with('projectDetail', TRUE)
							->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
		    }
		}

	}
	

	public function create($projectId, $iterationId){

		$user = Session::get('user');
	    $userRole = Session::get('user_role');

		$permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){

	    	// get project data
	    	$project = (array) Project::getName($projectId); 

	    	$iteration = (array) Iteration::get($iterationId); 

	    	$checklistItems = (array) Checklist::enumerateDefaultItems();

	        if(Input::has('_token')){

		        // get input valiues
		        $values = Input::get('values');	 

	        	// validation rules
	            if (!isset($values['new_principle']) && !isset($values['checklistItems'])){
	            	
	            	$rules =  array(
			          'title'       		=> 'required',
			          'closing_date'		=> 'required',		
			          'checklistItems' 		=> 'required'
		        	);

	            }else{

	            	$rules =  array(
			          'title'       		=> 'required',
			          'closing_date'		=> 'required'
			          );
	            }

	            // set validation rules to input values
		        $validator = Validator::make(Input::get('values'), $rules);

		        if(!$validator->fails()){

		        	$checklist = array(
	                  'enabled'        		=> Config::get('constant.ENABLED'),
	                  'project_id'          => $projectId,
	                  'status'				=> Config::get('constant.checklist.not_checked'),
	                  'title'             	=> $values['title'],
	                  'closing_date'        => $values['closing_date'],
	                  'iteration_id'  		=> $iterationId
	                ); 

	                // insert checklist on DB
              		$checklistId = Checklist::insert($checklist);  

              		if($checklistId>0) {

		                if(isset($values['checklistItems'])){
		                	foreach($values['checklistItems'] as $index => $checklistItem){

			                    $checklistBelongsItem = array(
			                    	'status'      					=> Config::get('constant.checklist.item.none'),
			                      	'comprobation_list_id'         	=> $checklistId,
			                        'comprobation_list_item_id'     => $checklistItem,
				                );

		                      $checklistBelongsItemId = Checklist::insertChecklistItem($checklistBelongsItem); 
		                  	}
		                }

		                if(isset($values['new_principle'])){
		                	$principlesId[] = array();
		                	foreach($values['new_principle'] as $index => $principle){

			                    $checklistPrinciple = array(
			                      	'rule'      	=> $principle['rule'],
			                      	'enabled'       => Config::get('constant.ENABLED'),
			                        'description'   => $principle['description'],
			                        'default'		=> Config::get('constant.checklist.not_default_item')
			                    );

			                    $principleId = Checklist::insertItems($checklistPrinciple); 
			                      
		                      	$checklistBelongsItem = array(
			                    	'status'      					=> Config::get('constant.checklist.item.none'),
			                      	'comprobation_list_id'        	=> $checklistId,
			                        'comprobation_list_item_id'     => $principleId,
				                );

				                $checklistBelongsItemId = Checklist::insertChecklistItem($checklistBelongsItem); 
		                  }
		                }

		                Session::flash('success_message', 'Se creó la lista de comprobación'); 

		                // save created project ID on session
		                Session::put('created_project_id', $projectId);

		                // redirect to invitation viee
		                return Redirect::to(URL::to('/'). '/listas-de-comprobacion/listado/'. $projectId . '/' . $iterationId);

		            }else{

                 		return View::make('frontend.project.create')
                              	->with('checklistItems', $checklistItems)
                              	->with('error_message', 'No se pudo crear la lista de comprobación')
                              	->with('iteration', $iteration) 
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
                              	->with('sizePrinciples', isset($values['new_principle']) ? count($values['new_principle']) : 0)
                              	->with('values', $values);
              		}

		        }else{

              		return View::make('frontend.checklist.create')
	                          	->withErrors($validator)
								->with('checklistItems', $checklistItems)
								->with('iteration', $iteration) 
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
	                          	->with('sizePrinciples', isset($values['new_principle']) ? count($values['new_principle']) : 0)
	                          	->with('values', $values);

           		} 
		    }else{


	         	// render view first time 
		        return View::make('frontend.checklist.create')
			    				->with('checklistItems', $checklistItems)
						    	->with('iteration', $iteration) 
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
			    				->with('sizePrinciples',0);
		    }
		}else{

			return Redirect::to(URL::action('DashboardController@index'));
		}

	}


	public function delete($checklistId){

    	//get comprobation_list by id data
    	$checklist = (array) Checklist::get($checklistId);
    	$projectId = $checklist['project_id'];
    	$iterationId = $checklist['iteration_id'];

		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($checklistId, 'comprobation_list', $user['id']); 

	    if(!$permission){

	    	return Redirect::to(URL::action('LoginController@index'));

	    }else{    	

	    	$newChecklistItems = (array) Checklist::enumerateNewItems($checklist['id']);

	      	// delete checklistItems
	  		Checklist::deleteChecklistItem($checklistId);

	  		// delete new checklistItems
			if(!empty($newChecklistItems)){
				foreach ($newChecklistItems as $newChecklistItem) {
					Checklist::deleteNewChecklistItem($newChecklistItem['id']);
				}
			}
			$checklist = Checklist::deleteChecklist($checklistId);

			if($checklist>0){

		        Session::flash('success_message', 'Se eliminó la lista de comprobación'); 

		        // save created project ID on session
		        Session::put('created_project_id', $projectId);

		        // redirect to invitation viee
		        return Redirect::to(URL::to('/'). '/listas-de-comprobacion/listado/'. $projectId . '/' . $iterationId);
			}else{

				Session::flash('error_message', 'No se pudo eliminar la lista de comprobación'); 

		        // save created project ID on session
		        Session::put('created_project_id', $projectId);

		        // redirect to invitation viee
		        return Redirect::to(URL::to('/'). '/listas-de-comprobacion/listado/'. $projectId . '/' . $iterationId);
			}
		}
    
	}	

	public function edit($checklistId){

		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	     $permission = User::userHasPermissionOnArtefact($checklistId, 'comprobation_list', $user['id']); 

	    if($permission && $userRole['user_role_id']==Config::get('constant.project.owner')){ 

	    	//get comprobation_list by id data
	    	$checklist = (array) Checklist::get($checklistId);

	    	$iterationId = $checklist['iteration_id'];

	    	// get iteration data
	    	$iteration = (array) Iteration::get($iterationId); 

	    	$projectId = $checklist['project_id'];

	    	// get project data
	    	$project = (array) Project::getName($projectId);

	    	$checklistItems = (array) Checklist::enumerateDefaultItems();

	    	$oldChecklistItems = (array) Checklist::enumerateOldItems($checklist['id']);
	    	$newChecklistItems = (array) Checklist::enumerateNewItems($checklist['id']);

	    	$values =  (array) $checklist;
	    	if (!empty($newChecklistItems)) {
	    		$values['new_principle'] = (array) $newChecklistItems;
	    	}

			$date = new DateTime($values['closing_date']);
			$values['closing_date']	= $date->format('d-m-Y');

	        if(Input::has('_token')){

		        // get input valiues
		        $values = Input::get('values');	 

	        	// validation rules
	            if (!isset($values['new_principle']) && !isset($values['checklistItems'])){
	            	
	            	$rules =  array(
			          'title'       		=> 'required',
			          'closing_date'		=> 'required',		
			          'checklistItems' 		=> 'required'
		        	);

	            }else{

	            	$rules =  array(
			          'title'       		=> 'required',
			          'closing_date'		=> 'required'
			          );
	            }

	            // set validation rules to input values
		        $validator = Validator::make(Input::get('values'), $rules);

		        if(!$validator->fails()){

		        	$checklist = array(
	                  'title'             	=> $values['title'],
	                  'closing_date'        => $values['closing_date']
	                ); 

	                // insert checklist on DB
              		$updateChecklist = Checklist::updateChecklist($checklistId, $checklist);  

              		if($updateChecklist>0) {

              			// delete checklistItems
                  		Checklist::deleteChecklistItem($checklistId);

                  		// delete new checklistItems
              			if(!empty($newChecklistItems)){
              				foreach ($newChecklistItems as $newChecklistItem) {
              					Checklist::deleteNewChecklistItem($newChecklistItem['id']);
							}
              			}

		                if(isset($values['checklistItems'])){

		                	foreach($values['checklistItems'] as $index => $checklistItem){

			                    $checklistBelongsItem = array(
			                    	'status'      					=> Config::get('constant.checklist.item.none'),
			                      	'comprobation_list_id'         	=> $checklistId,
			                        'comprobation_list_item_id'     => $checklistItem,
				                );

		                      $checklistBelongsItemId = Checklist::insertChecklistItem($checklistBelongsItem); 
		                  	}
		                }

		                if(isset($values['new_principle'])){
		                	$principlesId[] = array();
		                	foreach($values['new_principle'] as $index => $principle){

			                    $checklistPrinciple = array(
			                      	'rule'      	=> $principle['rule'],
			                      	'enabled'       => Config::get('constant.ENABLED'),
			                        'description'   => $principle['description'],
			                        'default'		=> Config::get('constant.checklist.not_default_item')
			                    );

			                    $principleId = Checklist::insertItems($checklistPrinciple); 
			                      
		                      	$checklistBelongsItem = array(
			                    	'status'      					=> Config::get('constant.checklist.item.none'),
			                      	'comprobation_list_id'        	=> $checklistId,
			                        'comprobation_list_item_id'     => $principleId,
				                );

				                $checklistBelongsItemId = Checklist::insertChecklistItem($checklistBelongsItem); 
		                  }
		                }

		                Session::flash('success_message', 'Se editó la lista de comprobación'); 

		                // save created project ID on session
		                Session::put('created_project_id', $projectId);

		                // redirect to invitation viee
		                return Redirect::to(URL::to('/'). '/listas-de-comprobacion/listado/'. $projectId . '/'. $iterationId);

		            }else{

                 		return View::make('frontend.checklist.edit')
                              	->with('checklist', $checklist)
                              	->with('error_message', 'No se pudo editar la lista de comprobación')
                              	->with('iteration', $iteration)
                              	->with('oldChecklistItems', $oldChecklistItems)
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
						    	->with('values', $values)
						    	->with('sizePrinciples', isset($values['new_principle']) ? count($values['new_principle']) : 0);
              		}

		        }else{

              		return View::make('frontend.checklist.edit')
	                          	->withErrors($validator)
	                          	->with('checklist', $checklist)
								->with('checklistItems', $checklistItems)
								->with('iteration', $iteration)
								->with('oldChecklistItems', $oldChecklistItems)
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
						    	->with('values', $values)
						    	->with('sizePrinciples', isset($values['new_principle']) ? count($values['new_principle']) : 0);

           		} 
		    }else{

	         	// render view first time 
		        return View::make('frontend.checklist.edit')
		        				->with('checklist', $checklist)
			    				->with('checklistItems', $checklistItems)
			    				->with('iteration', $iteration)
			    				->with('oldChecklistItems', $oldChecklistItems)
						    	->with('project', $project) 
						    	->with('projectDetail', TRUE)
						    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
						    	->with('values', $values)
						    	->with('sizePrinciples', isset($values['new_principle']) ? count($values['new_principle']) : 0);
		    }
		}else{

			return Redirect::to(URL::action('LoginController@index'));
		}

	}

	public function show($checklistId){

		//get user and user role
		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($checklistId, 'comprobation_list', $user['id']); 

	    if($permission){

	    	//get comprobation_list by id data
	    	$checklist = (array) Checklist::get($checklistId);
	    	$iterationId = $checklist['iteration_id'];
	    	$projectId = $checklist['project_id'];

	    	// get iteration data
	    	$iteration = (array) Iteration::get($iterationId);

	    	// get project data
	    	$project = (array) Project::getName($projectId);
	    	
	    	$checklistItems = (array) Checklist::enumerateAllItemsByChecklistId($checklistId);
		    
		    // render view first time 
	    	return View::make('frontend.checklist.show')
					->with('checklist', $checklist)
					->with('checklistItems', $checklistItems)
					->with('iteration', $iteration)
			    	->with('project', $project) 
			    	->with('projectDetail', TRUE)
			    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
		}else{

			return Redirect::to(URL::action('LoginController@index'));

		}
	    
	}

	public function export($checklistId){

		//get user and user role
		$user = Session::get('user');

		$permission = User::userHasPermissionOnArtefact($checklistId, 'comprobation_list', $user['id']); 

		if($permission){

			//get user and user role
			$user = Session::get('user');
		    $userRole = Session::get('user_role');

	    	//get comprobation_list by id data
	    	$checklist = (array) Checklist::get($checklistId);

	    	$checklistItems = (array) Checklist::enumerateAllItemsByChecklistId($checklistId);

	    	$checkListData['info'] = $checklist; 
	    	$checkListData['items'] = $checklistItems; 


		    $pdf = PDF::loadView('frontend.checklist.export', $checkListData);

		    return $pdf->download('proagil-'.$checklist['title'].'.pdf');	

		}else{

			return Redirect::to(URL::action('LoginController@index'));

		}	    	
	    
	}

	public function verify($checklistId){
		
		//get user and user role
		$user = Session::get('user');
	    $userRole = Session::get('user_role');

	    $permission = User::userHasPermissionOnArtefact($checklistId, 'comprobation_list', $user['id']); 

	    if(!$permission){

	    	return Redirect::to(URL::action('LoginController@index'));

	    }else{

    	//get comprobation_list by id data
    	$checklist = (array) Checklist::get($checklistId);

    	$projectId = $checklist['project_id'];    	
    	$iterationId = $checklist['iteration_id'];

    	// get iteration data
    	$iteration = (array) Iteration::get($iterationId); 
	    
    	// get project data
    	$project = (array) Project::getName($projectId);

	    	$checklistItems = (array) Checklist::enumerateAllItemsByChecklistId($checklistId);
	        if(Input::has('_token')){

	    		// get input valiues
		        $values = Input::get('values');	

			    if(sizeof($values)==sizeof($checklistItems)){
		        	
		        	//update each principles
			        foreach($values as $index => $status){
		                 
		              	$checklistBelongsItem = array(
		                	'status'      		=> $status
		                );

		                $updateChecklistBelongsItem = Checklist::updateChecklistItem($index, $checklistBelongsItem);
		          	}

		          	//update checklist
		        	$checklist = array(
		        		'status'      	=> Config::get('constant.checklist.checked') 
		        	);

		  	        $updateChecklist = Checklist::updateChecklist($checklistId, $checklist);

		        	if ($updateChecklist>0){

		        		Session::flash('success_message', 'Se verificó la lista de comprobación'); 

		                // redirect to invitation viee
		                return Redirect::to(URL::to('/'). '/listas-de-comprobacion/listado/'. $projectId . '/' . $iterationId);
		        	
		        	}else{
		        		Session::flash('error_message', 'No se pudo realizar la verificación de la lista de comprobación'); 

		                // redirect to invitation viee
		                return Redirect::to(URL::to('/'). '/listas-de-comprobacion/listado/'. $projectId . '/' . $iterationId);
		        	}
		    	}else {
		    	    // render view with errors 
		    		return View::make('frontend.checklist.verify')
		    				->with('checklist', $checklist)
		    				->with('checklistItems', $checklistItems)
		    				->with('iteration', $iteration)
		    				->with('error_message', 'Debe verificar todos los principios')
					    	->with('project', $project) 
					    	->with('projectDetail', TRUE)
					    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
					    	->with('values', $values);
		    	}   	

		    }else{
		    	     	// render view first time 
	    		return View::make('frontend.checklist.verify')
	    				->with('checklist', $checklist)
	    				->with('checklistItems', $checklistItems)
	    				->with('iteration', $iteration)
				    	->with('project', $project) 
				    	->with('projectDetail', TRUE)
				    	->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE);
		    }
		}

	}

}
