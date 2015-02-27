<?php

class ProjectController extends BaseController {

  public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        if(is_null(Session::get('user'))){
          return Redirect::to(URL::action('LoginController@index'));
        }

      });
  }

	public function create(){

      // view data
      $artefacts = Artefact::enumerate(); 
      $projectTypes = Project::selectProjectTypes(); 


		if(Input::has('_token')){

	        // validation rules
	        $rules =  array(
	          'name'         	       => 'required',
            'description'          => 'required',
            'project_type'         => 'required'
	        );

	        // set validation rules to input values
	        $validator = Validator::make(Input::get('values'), $rules);

	        // get input valiues
	        $values = Input::get('values');

           	if(!$validator->fails()){

              $project = array(
                'name'      	        => $values['name'],
                'description'         => $values['description'],
                'project_type_id'     => $values['project_type'],
                'enabled'             => Config::get('constant.ENABLED')                
              );

              // insert project on DB
              $projectId = Project::insert($project); 

              if($projectId>0) {

                //save project artefacts
                if(isset($values['artefacts'])){

                  foreach($values['artefacts'] as $index => $artefact){

                      $projectArtefact = array(
                          'project_id'      => $projectId,
                          'artefact_id'     => $artefact
                      );

                      Artefact::insertProjectArtefact($projectArtefact); 
                  }

                }

                // set user on session as owner of project
                $user = Session::get('user');

                $userRole = array(

                  'user_role_id'        => Config::get('constant.project.owner'),
                  'project_id'          => $projectId,
                  'user_id'             => $user['id']

                );

                User::userBelongsToProject($userRole);

                //- - -

                //TODO: send invitations with user emails

                //- - -

                // return to dashboard view


              }else{

                 return View::make('frontend.project.create')
                              ->with('error_message', 'No se pudo crear el proyecto')
                              ->with('values', $values)
                              ->with('artefacts', $artefacts)
                              ->with('projectTypes', $projectTypes);
              }

           	}else{

              return View::make('frontend.project.create')
                          ->withErrors($validator)
                          ->with('values', $values)
                          ->with('artefacts', $artefacts)
                          ->with('projectTypes', $projectTypes);

           	}

	      }else{

          // render view first time 
	        return View::make('frontend.project.create')
                      ->with('artefacts', $artefacts)
                      ->with('projectTypes', $projectTypes);
	      }

	}

  public function edit($projectId){

      // get view data
      $artefacts = Artefact::enumerate(); 
      $projectTypes = Project::selectProjectTypes(); 
      $project = Project::get($projectId); 
      $projectArtefacts = Project::getProjectArtefacts($projectId); 
      $values =  (array) $project;

      // - -

      // TODO: get users on project

      // - -

    if(Input::has('_token')){

          // validation rules
          $rules =  array(
            'name'                 => 'required',
            'description'          => 'required',
            'project_type'         => 'required'
          );

          // set validation rules to input values
          $validator = Validator::make(Input::get('values'), $rules);

          // get input valiues
          $values = Input::get('values');

            if(!$validator->fails()){

              $project = array(
                'name'                => $values['name'],
                'description'         => $values['description'],
                'project_type_id'     => $values['project_type'],          
              );

              // update project on DB
              $updatedProject = Project::edit($projectId, $project); 

              if($updatedProject) {

                  // delete old project artefacts
                  Artefact::deleteProjectArtefact($projectId);

                //save new project artefacts
                if(isset($values['artefacts'])){

                  foreach($values['artefacts'] as $index => $artefact){

                      $projectArtefact = array(
                          'project_id'      => $projectId,
                          'artefact_id'     => $artefact
                      );

                      //insert new project artefacts
                      Artefact::insertProjectArtefact($projectArtefact); 
                  }

                }

                //- - -

                //send invitations with user emails

                //- - -

                // return to dashboard view


              }else{

                  // show view with error message
                 return View::make('frontend.project.edit')
                              ->with('error_message', 'No se pudo crear el proyecto')
                              ->with('values', $values)
                              ->with('project', $project)
                              ->with('artefacts', $artefacts)
                              ->with('projectArtefacts', $projectArtefacts)
                              ->with('projectTypes', $projectTypes)
                              ->with('projectId', $projectId);
              }

            }else{

              // show view with errors
              return View::make('frontend.project.edit')
                          ->withErrors($validator)
                          ->with('values', $values)
                          ->with('project', $project)
                          ->with('artefacts', $artefacts)
                          ->with('projectArtefacts', $projectArtefacts)
                          ->with('projectTypes', $projectTypes)
                          ->with('projectId', $projectId);

            }

        }else{

          // render view first time 
          return View::make('frontend.project.edit')
                      ->with('artefacts', $artefacts)
                      ->with('projectTypes', $projectTypes)
                      ->with('projectArtefacts', $projectArtefacts)
                      ->with('values', $values)
                      ->with('project', $project)
                      ->with('projectId', $projectId); 
        }

  }

  public function detail(){

    return View::make('frontend.project.detail'); 
  }

}