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

      // get view data
      $artefacts = (array) Artefact::enumerate(); 
      $projectTypes = (array) Project::selectProjectTypes(); 


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

                //save project activity categories
                if(isset($values['new_category'])) {

                  foreach($values['new_category'] as $index => $category){

                      $activityCategory = array(
                        'name'        => $category,
                        'project_id'  => $projectId
                      );

                      ActivityCategory::insert($activityCategory);

                  }              

                }

                // get user on session
                $user = Session::get('user');

                $userRole = array(

                  'user_role_id'        => Config::get('constant.project.owner'),
                  'project_id'          => $projectId,
                  'user_id'             => $user['id']

                );

                // save user on session as project owner
                User::userBelongsToProject($userRole);

                Session::flash('success_message', 'Se ha creado exitosamente su proyecto en el sistema, si lo desea puede invitar a otros a colaborar'); 

                // save created project ID on session
                Session::put('created_project_id', $projectId);

                // redirect to invitation view
                return Redirect::to(URL::action('ProjectController@invitation'));

              }else{

                 return View::make('frontend.project.create')
                              ->with('error_message', 'No se pudo crear el proyecto')
                              ->with('values', $values)
                              ->with('artefacts', $artefacts)
                              ->with('projectTypes', $projectTypes)
                              ->with('create_project', TRUE);
              }

           	}else{

              return View::make('frontend.project.create')
                          ->withErrors($validator)
                          ->with('values', $values)
                          ->with('artefacts', $artefacts)
                          ->with('projectTypes', $projectTypes)
                          ->with('create_project', TRUE);

           	}

	      }else{

          // render view first time 
	        return View::make('frontend.project.create')
                      ->with('artefacts', $artefacts)
                      ->with('projectTypes', $projectTypes)
                      ->with('create_project', TRUE);
	      }

	}

  public function invitation(){

      $userRoles = User::getRoles(); 

      if(Input::has('_token')) {

        // get data from post input
        $invitations = Input::get('invitations');

        // create validation rules array
        $rules = array();  
        foreach($invitations['email'] as $index => $invitation){
          $rules['email.'.$index] = 'required|email';
          $rules['role.'.$index] = 'required';
        }

        // validate
        $validator = Validator::make($invitations, $rules);

           // if validator fails
           if(!$validator->fails()){

                // get invitations 
                foreach($invitations['email'] as $index => $email){

                  $userInvitation = array(
                      'email'         => $email,
                      'project_id'    => Session::get('created_project_id'),
                      'user_role_id'  => $invitations['role'][$index],
                      'token'         => md5($email.date('H:i:s'))
                  );

                  if(User::saveInvitation($userInvitation)>0){

                    // verify if users email already exist on DB
                    $savedUser = (array) User::getUserByEmail($email);

                      if(!empty($savedUser)){

                        // create email data
                        $emailData = array(
                          'user_name'     => $savedUser['first_name'],
                          'url_token'     => URL::to('/'). '/proyecto/validar-invitacion/'. $userInvitation['token']

                        );

                        // send email with invitation to registered user
                        Mail::send('frontend.email_templates.validateInvitation', 

                        $emailData, 

                        function($message) use ($email){

                          $message->to($email);
                          $message->subject('PROAGIL: Invitación a formar parte de un proyecto');
                        }); 

                      
                        }else{

                          // create email data
                          $emailData = array(
                            'user_name'     => $email,
                            'url_token'     => URL::to('/'). '/registro/validar-invitacion/'. $userInvitation['token']

                          );                          

                            // send email with invitation to unregistered user
                            Mail::send('frontend.email_templates.validateInvitation', 

                            $emailData, 

                            function($message) use ($email){

                              $message->to($email);
                              $message->subject('PROAGIL: Invitación a registrarte para formar parte de un proyecto');
                            });                         

                        }

                          Session::flash('success_message', 'Se han enviado las invitaciones a los correos indicados'); 

                          return Redirect::to(URL::action('DashboardController@index'));

                      }

                    } //end foreach

              }else{
                 return View::make('frontend.project.invitation')
                            ->withErrors($validator)
                            ->with('values', $values);

              }

        }else{             
        // first time 
          return View::make('frontend.project.invitation')
                       ->with('userRoles', $userRoles)
                       ->with('projectId', Session::get('created_project_id'));
        }
      

  }

  public function editInvitation($projectId) {

      $userRoles = User::getRoles(); 
      $usersOnProject = (array) Project::getUsersOnProject($projectId, Session::get('user')['id']);
      $project = (array) Project::get($projectId); 

      if(Input::has('_token')) {

          // update user role on project
          if(Input::get('invitations')!=NULL){

              $savedInvitations = Input::get('invitations');

              foreach($savedInvitations['role'] as $id => $savedInvitation) {

                $newUserRole = array(
                  'user_role_id'  => $savedInvitation
                );

                User::EditUserBelongsToProject($id, $projectId, $newUserRole);

              }
          }

          // save new invitations
          if(Input::get('new_invitations')!=NULL){

            $invitations = Input::get('new_invitations');

            foreach($invitations['email'] as $index => $email){

              $userInvitation = array(
                  'email'         => $email,
                  'project_id'    => $projectId,
                  'user_role_id'  => $invitations['role'][$index],
                  'token'         => md5($email.date('H:i:s'))
              );

              if(User::saveInvitation($userInvitation)>0){

                // verify if users email already exist on DB
                $savedUser = (array) User::getUserByEmail($email);

                  if(!empty($savedUser)){

                    // create email data
                    $emailData = array(
                      'user_name'     => $savedUser['first_name'],
                      'url_token'     => URL::to('/'). '/proyecto/validar-invitacion/'. $userInvitation['token']

                    );

                    // send email with invitation to registered user
                    Mail::send('frontend.email_templates.validateInvitation', 

                    $emailData, 

                    function($message) use ($email){

                      $message->to($email);
                      $message->subject('PROAGIL: Invitación a formar parte de un proyecto');
                    }); 

                  
                    }else{

                      // create email data
                      $emailData = array(
                        'user_name'     => $email,
                        'url_token'     => URL::to('/'). '/registro/validar-invitacion/'. $userInvitation['token']

                      );                          

                        // send email with invitation to unregistered user
                        Mail::send('frontend.email_templates.validateInvitation', 

                        $emailData, 

                        function($message) use ($email){

                          $message->to($email);
                          $message->subject('PROAGIL: Invitación a registrarte para formar parte de un proyecto');
                        });                         

                    }

                  }

                } 
              }

              // FIXME

              // - - - PROJECT NAME

              // - - 

              Session::flash('success_message', 'Se han modificado las invitaciones del proyecto XXXXX'); 

              return Redirect::to(URL::action('DashboardController@index'));

        }else{       

          // first time 
          return View::make('frontend.project.editInvitation')
                       ->with('userRoles', $userRoles)
                       ->with('projectId', $projectId)
                       ->with('usersOnProject', $usersOnProject)
                       ->with('project', $project);
        }
      


  }

  public function validateInvitation($token){

    $invitation = (array) User::getInvitationByToken($token);

    if(empty($invitation)){

        return Redirect::to(URL::action('LoginController@index'));

    }else{

      // get user data
      $user = (array) User::getUserByEmail($invitation['email']);
      
        $userRole = array(

          'user_role_id'        => $invitation['user_role_id'],
          'project_id'          => $invitation['project_id'],
          'user_id'             => $user['id']

        );

        // get project name

        // -- 

        // --

        // TODO

        // save user as project member
        User::userBelongsToProject($userRole);    

        Session::flash('success_message', 'Ya eres parte del proyecto XXXX. Se ha agregado a tu lista'); 


        return Redirect::to(URL::action('DashboardController@index'));  

    }

  }

  public function deleteUserOnProject($userId, $projectId){

    if(User::deleteUserOnProject($userId, $projectId)){

      $result = array(
          'error'     => false
      );

    }else{

      $result = array(
          'error'     => true
      );

    }
      header('Content-Type: application/json');
      return Response::json($result);


  }

  public function edit($projectId){

      // get view data
      $artefacts = (array) Artefact::enumerate(); 
      $projectTypes = (array) Project::selectProjectTypes(); 
      $project = (array) Project::get($projectId); 
      $projectArtefacts = (array) Project::getProjectArtefacts($projectId); 
      $values =  (array) $project;


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

                 return Redirect::to(URL::action('ProjectController@detail', array($projectId)));


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

  public function detail($projectId){

    $user = Session::get('user'); 
    $userRole = (array) User::getUserRoleOnProject($projectId, $user['id']);

    // save user role on session
    Session::put('user_role', $userRole);


    if(empty($userRole)){

      return Redirect::to(URL::action('DashboardController@index'));  

    }else{
          // get project data
          $project =  (array) Project::get($projectId);
          $projectArtefacts = (array) Project::getProjectArtefacts($projectId, 'ALL');

          // project list on sidebar
          $ownerProjects = Project::getOwnerProjects($user['id']);
          $ownerProjects = (count($ownerProjects)>=6)?array_slice($ownerProjects, 0, 6):$ownerProjects;

          // get activity categories
          $activityCategories = (array) ActivityCategory::get($projectId);


          // get filters with categories and status
          $filters = NULL;
          $filtersArray = array();  
          $status = NULL;
          $statusArray = array(); 

          if(Input::has('_token')){

             $filters = Input::get('filters');

             if($filters['category']!=''){
                 $filtersArray =  explode(',', $filters['category']);
             }

            if($filters['status']!=''){
                 $statusArray =  explode(',', $filters['status']);
             }

          }

          // get activities
          $activities = Project::getProjectActivities($projectId, $filtersArray, $statusArray);

          // add activity status class
          foreach($activities as $index => $activity){

             switch($activity['status']) {
              case 1:
                $activities[$index]['status_class'] = 'fc-grey-iv';
              break;

              case 2:
                $activities[$index]['status_class'] = 'fc-yellow';
              break;

              case 3:
                $activities[$index]['status_class'] = 'fc-green';
              break;

             }

          }

          return View::make('frontend.project.detail')
                ->with('projectDetail', TRUE) 
                ->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
                ->with('project', $project)
                ->with('projectArtefacts', $projectArtefacts)
                ->with('activityCategories', $activityCategories)
                ->with('ownerProjects', $ownerProjects)
                ->with('activities', $activities)
                ->with('filters', $filters)
                ->with('filtersArray', $filtersArray)
                ->with('statusArray', $statusArray)
                ->with('projectId', $projectId);   

    }

  }

  public function delete($projectId){

      // get user on session
      $user = Session::get('user');   

      $isOwner = Project::userIsOwner($user['id'], $projectId);

      // verify if user on session is owner of project
      if(empty($isOwner)) {

      }else{

        // delete artefacts on project

        // delete users on project

        // delete activity categories

        // delete activity

      }


  }

  public function friendlyURL($str) {

    $delimiter='-'; 

    if( !empty($replace) ) {
      $str = str_replace((array)$replace, ' ', $str);
    }

    $friendlyURL = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $friendlyURL = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $friendlyURL);
    $friendlyURL = strtolower(trim($friendlyURL, '-'));
    $friendlyURL = preg_replace("/[\/_|+ -]+/", $delimiter, $friendlyURL);

    return $friendlyURL;

  }
  


}