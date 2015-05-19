<?php

class ProjectController extends BaseController {

  public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        $user = Session::get('user'); 
        $project = Session::get('project'); 


        if($project!=NULL){
          $userRole = (array) User::getUserRoleOnProject($project['id'], $user['id']);
          if(!($userRole['user_id']==$user['id'])){
              return Redirect::to(URL::action('LoginController@index'));
          }
        } 

        if(is_null(Session::get('user'))){
          return Redirect::to(URL::action('LoginController@index'));
        }

      });
  }

	public function create(){

    // get view data
    $artefacts = (array) Artefact::enumerate(); 
    $roles = User::getRoles(); 

		if(Input::has('_token')){

          // get input valiues
          $values = Input::get('values');

          //print_r($values); die; 

          // validation rules
          $rules =  array(
            'name'                 => 'required',
          );

          // set validation rules to input values
          $validator = Validator::make(Input::get('values'), $rules);

          if(!$validator->fails()){

              $project = array(
                'name'                => isset($values['name'])?$values['name']:NULL,
                'objetive'            => isset($values['objetive'])?$values['objetive']:NULL,
                'client'              => isset($values['client'])?$values['client']:NULL,
                'enabled'             => 1    
              );

              // insert project on DB
              $projectId = Project::insert($project); 

              if($projectId>0) {

                //save project ITERATIONS
                if(isset($values['iteration'])){

                   foreach($values['iteration'] as $index => $iteration){
                      
                      $projectIteration = array(
                          'name'        => $iteration['name'],
                          'order'       => $iteration['order'],
                          'init_date'   => $iteration['init_date'],
                          'end_date'    => $iteration['end_date'],
                          'project_id'  => $projectId
                      );

                      // save ITERATION info
                     $iterationId = Iteration::insert($projectIteration); 

                      if(isset($iteration['artefacts']) && !empty($iteration['artefacts'])){

                          // save iteration ARTEFACTS
                          foreach($iteration['artefacts'] as $index => $artefact){

                              $projectArtefact = array(
                                  'project_id'      => $projectId,
                                  'artefact_id'     => $artefact,
                                  'iteration_id'    => $iterationId
                              );

                              Artefact::insertProjectArtefact($projectArtefact);                             


                          } // end foreach artefacts

                      } // end if artefacts

                      if(isset($iteration['colaborator']) && !empty($iteration['colaborator'])){

                          // get iteration COLABORATORS 
                          foreach($iteration['colaborator'] as $index => $colaborator){

                              $email = $colaborator['email']; 

                              $userInvitation = array(
                                  'email'         => $colaborator['email'],
                                  'project_id'    => $projectId,
                                  'iteration_id'  => $iterationId,
                                  'user_role_id'  => $colaborator['role'],
                                  'token'         => md5($colaborator['email'].date('H:i:s'))
                              ); 

                               // get user on session data
                              $user = Session::get('user');

                              if(User::saveInvitation($userInvitation)>0){

                                // verify if user email already exist on DB
                                $savedUser = (array) User::getUserByEmail($colaborator['email']);

                                if(!empty($savedUser)){

                                  // create email data
                                  $emailData = array(
                                    'url_token'       => URL::to('/'). '/proyecto/validar-invitacion/'. $userInvitation['token'],
                                    'user_name'       => $user['first_name'].' '.$user['last_name'],
                                    'project_name'    =>  $values['name'],
                                    'iteration_name'  => $iteration['name']

                                  );

                                  // send email with invitation to registered user
                                  Mail::send('frontend.email_templates.validateInvitation', 

                                  $emailData, 

                                  function($message) use ($email){

                                    $message->to($email);
                                    $message->subject('PROAGIL: Invitación a formar parte de un proyecto');
                                  }); 


                                }else{

                                    // create email data for new user
                                    $emailData = array(
                                      'url_token'     => URL::to('/'). '/registro/validar-invitacion/'. $userInvitation['token'],
                                      'user_name'     => $user['first_name'].' '.$user['last_name'],
                                      'project_name'  =>  $values['name'],
                                      'iteration_name'  => $iteration['name']

                                    );                          

                                      // send email with invitation to unregistered user
                                      Mail::send('frontend.email_templates.validateInvitation', 

                                      $emailData, 

                                      function($message) use ($email){

                                        $message->to($email);
                                        $message->subject('PROAGIL: Invitación a registrarte para formar parte de un proyecto');
                                      });                                   


                                } // end if !empty(savedUser)


                              } // end if  User::saveInvitation                        



                            } // end foreach colaborators

                        }   // end if colaborators 

                          // add user on iteration 
                          $user = Session::get('user');    

                          // save user on session as project iteratins OWNER
                          $userRole = array(

                            'user_role_id'        => Config::get('constant.project.owner'),
                            'project_id'          => $projectId,
                            'user_id'             => $user['id'],
                            'iteration_id'        => $iterationId 

                          );

                          // save user on session as project owner
                          User::userBelongsToProject($userRole);                        


                   } // end foreach iterations


                    Session::flash('success_message', 'Se ha creado el proyecto y sus iteraciones'); 

                    // save created project ID on session
                    Session::put('created_project_id', $projectId);

                    // redirect to invitation view
                    return Redirect::to(URL::action('DashboardController@index'));                   

                } // end if iterations                


              }else{

               return View::make('frontend.project.create')
                          ->with('error_message', 'No se pudo crear el proyecto')
                          ->with('values', $values)
                          ->with('artefacts', $artefacts)
                          ->with('roles', $roles)
                          ->with('create_project', TRUE);                     

              }            

          }else{

              return View::make('frontend.project.create')
                          ->with('error_message', 'No se pudo crear el proyecto')
                          ->with('values', $values)
                          ->with('artefacts', $artefacts)
                          ->with('roles', $roles)
                          ->with('create_project', TRUE);           

          }

	   }else{

          // render view first time 
	        return View::make('frontend.project.create')
                      ->with('artefacts', $artefacts)
                      ->with('create_project', TRUE)
                      ->with('roles', $roles);
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
                      'token'         => md5($email.date('H:i:s')),
                      'iteration_id'  => 1 //TODO: ASIGNAR $iterationId
                  );

                    // get user on session data
                    $user = Session::get('user');

                    // get project data
                    $project = (array) Project::getName(Session::get('created_project_id'));            

                  if(User::saveInvitation($userInvitation)>0){


                    // verify if user email already exist on DB
                    $savedUser = (array) User::getUserByEmail($email);

                      if(!empty($savedUser)){

                        // create email data
                        $emailData = array(
                          'user_name'     => $savedUser['first_name'],
                          'url_token'     => URL::to('/'). '/proyecto/validar-invitacion/'. $userInvitation['token'],
                          'user_name'     => $user['first_name'].' '.$user['last_name'],
                          'project_name'  =>  $project['name']

                        );

                        // send email with invitation to registered user
                        Mail::send('frontend.email_templates.validateInvitation', 

                        $emailData, 

                        function($message) use ($email){

                          $message->to($email);
                          $message->subject('PROAGIL: Invitación a formar parte de un proyecto');
                        }); 

                      
                        }else{

                          // create email data for new user
                          $emailData = array(
                            'user_name'     => $email,
                            'url_token'     => URL::to('/'). '/registro/validar-invitacion/'. $userInvitation['token'],
                            'user_name'     => $user['first_name'].' '.$user['last_name'],
                            'project_name'  =>  $project['name']

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
                  'token'         => md5($email.date('H:i:s')),
                  'iteration_id'  => 1 //TODO: ASIGNAR $iterationId
              );

                   // get user on session data
                  $user = Session::get('user');

                  // get project data
                  $project = (array) Project::getName($projectId);         

              if(User::saveInvitation($userInvitation)>0){

                // verify if users email already exist on DB
                $savedUser = (array) User::getUserByEmail($email);

                  if(!empty($savedUser)){

                    // create email data
                    $emailData = array(
                      'user_name'     => $savedUser['first_name'],
                      'url_token'     => URL::to('/'). '/proyecto/validar-invitacion/'. $userInvitation['token'],
                      'user_name'     => $user['first_name'].' '.$user['last_name'],
                      'project_name'  => $project['name']

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
                        'user_name'       => $email,
                        'url_token'       => URL::to('/'). '/registro/validar-invitacion/'. $userInvitation['token'],
                        'user_name'       => $user['first_name'].' '.$user['last_name'],
                        'project_name'    => $project['name']

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


              Session::flash('success_message', 'Se han modificado las invitaciones del proyecto '.$project['name']); 

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
          'iteration_id'        => $invitation['iteration_id'],
          'user_id'             => $user['id']

        );

        // get project name
        $project = (array) Project::getName($invitation['project_id']);


        // get iteration name
        $iteration = (array) Iteration::get($invitation['iteration_id']);   

        // save user as project member
        User::userBelongsToProject($userRole);    

        Session::flash('success_message', 'Ya eres parte de la iteraci&oacute;n '. $iteration['name'].' del proyecto '. $project['name']); 

        // delete token on invitation
        User::updateInvitation($invitation['id'], array('token'=>NULL)); 


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

  public function editInfo($projectId){

    $user = Session::get('user'); 
    $userRole = (array) User::getUserRoleOnProject($projectId, $user['id']);

    if(empty($userRole) || $userRole['user_role_id'] == Config::get('constant.project.member')){

      return Redirect::to(URL::action('DashboardController@index')); 

    }else{ 

      $project = (array) Project::get($projectId); 

      if(Input::has('_token')){

            // get input valiues
            $values = Input::get('values');


            // validation rules
            $rules =  array(
              'name'                 => 'required'
            );

            // set validation rules to input values
            $validator = Validator::make(Input::get('values'), $rules);

            if(!$validator->fails()){

              $projectInfo = array(
                'name'          => $values['name'],
                'objetive'      => $values['objetive'],
                'client'        => $values['client']
              );

              Project::edit($projectId, $projectInfo);

              Session::flash('success_message', 'Se ha editado el proyecto'); 

              return Redirect::to(URL::action('DashboardController@index'));            

            }else{

              // show errors
              return View::make('frontend.project.editInfo')
                    ->with('values', $project)
                    ->withErrors($validator)
                    ->with('projectName', $project['name'])
                    ->with('projectId', $projectId); 
      }      

      }else{

        return View::make('frontend.project.editInfo')
                    ->with('values', $project)
                    ->with('projectName', $project['name'])
                    ->with('projectId', $projectId); 

      }

    }

  }

  public function edit($projectId){

    // get view data
    $artefacts = (array) Artefact::enumerate(); 
    $totalArtefacts = Artefact::countArtefacts(); 
    $projectTypes = (array) Project::selectProjectTypes(); 
    $project = (array) Project::get($projectId); 
    $projectArtefacts = (array) Project::getProjectArtefacts($projectId, 'ALL'); 
    $projectArtefactsSimple = (array) Project::getProjectArtefacts($projectId); 
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
                'enabled'             => 1         
              );

              // update project on DB
              $updatedProject = Project::edit($projectId, $project); 

              if($updatedProject) {

                //save new project artefacts
                if(isset($values['artefacts'])){

                  foreach($values['artefacts'] as $index => $artefact){

                      $projectArtefact = array(
                          'project_id'      => $projectId,
                          'artefact_id'     => $artefact,
                          'iteration_id'    => 1 //TODO: ASIGNAR $iterationId
                      );

                      //insert new project artefacts
                      Artefact::insertProjectArtefact($projectArtefact); 
                  }

                }

                  Session::flash('success_message', 'Se editó el proyecto'); 

                 return Redirect::to(URL::action('ProjectController@detail', array($projectId)));


              }else{


                  // show view with error message
                 return View::make('frontend.project.edit')
                              ->with('error_message', 'No se pudo editar el proyecto')
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

          //render view first time 
          return View::make('frontend.project.edit')
                      ->with('artefacts', $artefacts)
                      ->with('totalArtefacts', $totalArtefacts)
                      ->with('projectTypes', $projectTypes)
                      ->with('projectArtefacts', $projectArtefacts)
                      ->with('projectArtefactsSimple', $projectArtefactsSimple)                             
                      ->with('values', $values)
                      ->with('project', $project)
                      ->with('projectId', $projectId); 
        }

  }

  public function detail($projectId, $iterationId){

    $user = Session::get('user'); 
    $userRole = (array) User::getUserRoleOnIteration($iterationId, $user['id']);
    // save user role on session
    Session::put('user_role', $userRole);

    $permission = User::userHasPermissionOnProjectIteration($projectId, $iterationId, $user['id']);   

    if(empty($userRole) || !$permission){

      return Redirect::to(URL::action('DashboardController@index'));  

    }else{
      // get project data
      $project =  (array) Project::get($projectId);
      Session::put('project', $project);  

      //get user On iteration
      $users =  array('0' => 'Seleccione un usuario'); 
      $usersOnIteration = Project::getAllUsersOnIteration($iterationId);
      $usersOnIteration = $users+$usersOnIteration;     

      // get activity categories
      $activityCategories = (array) ActivityCategory::get($projectId);

      // get project iterations
      $projectIterations = (array) Project::getProjectIterations($user['id'], $projectId);
      $iteration = $projectIterations[$iterationId];

      // format date
      $date = new DateTime($iteration['init_date']);
      $iteration['init_date'] = $date->format('d/m/Y');
      $date = new DateTime($iteration['end_date']);
      $iteration['end_date'] = $date->format('d/m/Y');

      // get artefacts by iteration
      $iterationArtefacts =  (array) Iteration::getArtefactsByIteration($iterationId); 

      // get all artefacts
      $allArtefacts = (array) Artefact::enumerate();
      if (!empty($iterationArtefacts)) {
         foreach ($iterationArtefacts as $key => $value) {
          $iterationArtefactsSimple[$key] = $value['id'];
        }
      }else{
        $iterationArtefactsSimple = $iterationArtefacts;
      }

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
      $activities = Project::getIterationActivities($iterationId, $filtersArray, $statusArray);

      // add activity status class and name
      foreach($activities as $index => $activity){

         switch($activity['status']) {
          case 1:
            $activities[$index]['status_class'] = 'fc-grey-iv';
            $activities[$index]['status_name'] = 'Asignada';
          break;

          case 2:
            $activities[$index]['status_class'] = 'fc-yellow';
            $activities[$index]['status_name'] = 'Iniciada';
          break;

          case 3:
            $activities[$index]['status_class'] = 'fc-green';
            $activities[$index]['status_name'] = 'Terminada';
          break;

         }

         // format activities date
       
        // get activity comments
        $activityComments = array();
        $activityComments = Activity::getComments($activity['id']); 

        if(!empty($activityComments)) {
           foreach($activityComments as $indexS => $comment){
              $activityComments[$indexS]['editable'] = ($user['id']==$comment['user_id'])?TRUE:FALSE; 
               $activityComments[$indexS]['date'] = date('d/m/Y', strtotime($comment['date']));  
          }
        }

        // save activity comments
        $activities[$index]['comments'] = $activityComments;      

        // format activities intervals
        $start_date = new DateTime($activity['start_date']);
        $closing_date = new DateTime($activity['closing_date']);

        $interval = $start_date->diff($closing_date);

        $activities[$index]['interval'] = $interval->format('%a d&iacute;as');

      }

      
      return View::make('frontend.project.detail')
            ->with('activities', $activities)    
            ->with('activityCategories', $activityCategories)
            ->with('allArtefacts', $allArtefacts)
            ->with('filters', $filters)
            ->with('filtersArray', $filtersArray)
            ->with('iteration', $iteration)                    
            ->with('iterationArtefacts', $iterationArtefacts)
            ->with('iterationArtefactsSimple', $iterationArtefactsSimple)
            ->with('iterationId', $iterationId)
            ->with('project', $project)
            ->with('projectArrows', count($iterationArtefacts)>6)
            ->with('projectDetail', TRUE) 
            ->with('projectId', $projectId)
            ->with('projectIterations', $projectIterations)            
            ->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
            ->with('statusArray', $statusArray)
            ->with('usersOnIteration', $usersOnIteration);   

    }

  }

  public function deleteArtefact(){

    $values = Input::get('values');

    $artefact = Artefact::getByFriendlyUrl($values['artefact_friendly_url']);

    $deletedData = FALSE; 

          if(!empty($artefact)){  

            $iterationId = $values['iteration_id'];
            $projectId = $values['project_id'];
            $artefactId = $values['artefact_id']; 

             switch($values['artefact_friendly_url']) {

                  case Config::get('constant.artefact.heuristic_evaluation'):

                     $artefactList = HeuristicEvaluation::getEvaluationDataByIteration($iterationId); 

                      if(!empty($artefactList)){

                        // delete artefact elements
                        foreach($artefactList as $artefactValue){

                          if(!empty($artefactValue['elements'])){

                            foreach($artefactValue['elements'] as $element){

                              HeuristicEvaluation::deleteElement($element['id']);

                            }                    
                          }
                        }

                          // delete artefact info
                          foreach($artefactList as $artefact){

                            HeuristicEvaluation::_delete($artefact['id']);

                          } 

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                           $deletedData = TRUE;                        

                      }else{

                        //delete relation artefact -iteration
                        Artefact::deleteIterationArtefact($artefactId, $iterationId);

                          $deletedData = TRUE;    

                      } 

                        break;

                  case Config::get('constant.artefact.storm_ideas'):

                      $artefactList = StormIdeas::enumerate($iterationId); 
                    
                      if(!empty($artefactList)){

                        // delete artefact 
                        foreach($artefactList as $artefactValue){

                          if(!empty($artefactValue)){

                              StormIdeas::deleteStormIdeas($artefactValue['id']);

                          }                  
                                        
                        }

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                          $deletedData = TRUE;    

                      } 

                          break; 

                  case Config::get('constant.artefact.probe'):

                     $artefactList = Probe::getProbeElementsByIteration($iterationId); 

                      if(!empty($artefactList)){

                        // delete artefact elements
                        foreach($artefactList as $artefactValue){

                          if(!empty($artefactValue['elements'])){

                            foreach($artefactValue['elements'] as $element){

                              Probe::deleteQuestion($element['id']);

                            }                    
                          }
                        }

                          // delete artefact info
                          foreach($artefactList as $artefact){

                            Probe::_delete($artefact['id']);

                          } 

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                           $deletedData = TRUE;                        

                      }else{

                         //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                          $deletedData = TRUE;    

                      }    

                          break;

                  case Config::get('constant.artefact.style_guide'):

                      $artefactList = StyleGuide::getStyleGuideByIteration($iterationId); 
                    
                      if(!empty($artefactList)){

                        // delete artefact elements
                        foreach($artefactList as $artefactValue){

                            if(!empty($artefactValue['colors'])){

                              foreach($artefactValue['colors'] as $color){

                                StyleGuide::deleteColor($color['id']);

                              }                    
                            }

                            if(!empty($artefactValue['fonts'])){

                              foreach($artefactValue['fonts'] as $font){

                                StyleGuide::deleteFont($font['id']);

                              }                    
                            }
                          }                        

                          // delete artefact info
                          foreach($artefactList as $artefact){

                            StyleGuide::deleteStyleGuide($artefact['id']);

                          } 

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                           $deletedData = TRUE;                        

                      }else{

                         //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                          $deletedData = TRUE;    

                      } 

                      break;

                  case Config::get('constant.artefact.existing_system'):

                     $artefactList = ExistingSystem::getExistingSystemDataByIteration($iterationId); 

                      if(!empty($artefactList)){

                        // delete artefact elements
                        foreach($artefactList as $artefactValue){

                          if(!empty($artefactValue['elements'])){

                            foreach($artefactValue['elements'] as $element){

                              ExistingSystem::deleteElement($element['id']);

                            }                    
                          }
                        }

                          // delete artefact info
                          foreach($artefactList as $artefact){

                            ExistingSystem::_delete($artefact['id']);

                          } 

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                          $deletedData = TRUE;    

                      }                 

                          break;

                  case Config::get('constant.artefact.checklist'):

                     $artefactList = Checklist::getChecklistsByIterarion($iterationId);

                      if(!empty($artefactList)){

                        // delete artefact elements
                        foreach($artefactList as $artefactValue){

                          if(!empty($artefactValue['elements'])){

                            foreach($artefactValue['elements'] as $element){

                                Checklist::deleteChecklitsElement($element['id']);

                            }
                          }                    
                        }

                          // delete artefact info
                          foreach($artefactList as $artefact){

                            Checklist::deleteChecklist($artefact['id']);

                          } 

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact -iteration
                          Artefact::deleteIterationArtefact($artefactId, $iterationId);

                          $deletedData = TRUE;    

                      }  

                        break;
            }                       

              if($deletedData){

                $result = array(
                    'error'   => false,
                );

              }else{

                $result = array(
                    'error'     => true
                );

              }

              header('Content-Type: application/json');
              return Response::json($result);             


          }else{

            return Redirect::to(URL::action('LoginController@index'));
          }    

  }

  public function delete($projectId){

      // get user on session
      $user = Session::get('user');   

      $isOwner = Project::userIsOwner($user['id'], $projectId);

      // verify if user on session is owner of project
      if(empty($isOwner)) {

        return Redirect::to(URL::action('DashboardController@index')); 

      }else{

          // get project iterations
          $iterations = Project::getProjectIterations($user['id'], $projectId);

           Project::deleteCategoriesActivity($projectId); 

          if(!empty($iterations)){

            foreach($iterations as $iteration){

                // delete project activities
                $activities = Project::getIterationActivities($iteration['id']);    
                
                if(!empty($activities)){

                  foreach($activities as $activity){
                    Activity::deleteActivityComment($activity['activity_id']);
                    Activity::deleteProjectActivity($activity['activity_id'], $itetation['id']);
                    Activity::deleteActivity($activity['activity_id']); 
                  
                  }

                }                           

              }
          }

              // get project artefacts
              $projectArtefacts = (array) Project::getProjectArtefacts($projectId, 'ALL'); 

              if(!empty($projectArtefacts)){

                foreach( $projectArtefacts as $index => $projectArtefact){

                       switch($projectArtefact['friendly_url']) {

                            case Config::get('constant.artefact.heuristic_evaluation'):

                               $artefactList = HeuristicEvaluation::getEvaluationDataByProject($projectId); 

                                if(!empty($artefactList)){

                                  // delete artefact elements
                                  foreach($artefactList as $artefactValue){

                                    if(!empty($artefactValue['elements'])){

                                      foreach($artefactValue['elements'] as $element){

                                        HeuristicEvaluation::deleteElement($element['id']);

                                      }                    
                                    }
                                  }

                                    // delete artefact info
                                    foreach($artefactList as $artefact){

                                      HeuristicEvaluation::_delete($artefact['id']);

                                    } 

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                    $deletedData = TRUE;    

                                } 

                                  break;

                            case Config::get('constant.artefact.storm_ideas'):

                                $artefactList = StormIdeas::enumerate($projectId); 
                              
                                if(!empty($artefactList)){

                                  // delete artefact 
                                  foreach($artefactList as $artefactValue){

                                    if(!empty($artefactValue)){

                                        StormIdeas::deleteStormIdeas($artefactValue['id']);

                                    }                  
                                                  
                                  }

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                    $deletedData = TRUE;    

                                } 

                                    break; 

                            case Config::get('constant.artefact.probe'):

                               $artefactList = Probe::getProbeElementsByProject($projectId); 

                                if(!empty($artefactList)){

                                  // delete artefact elements
                                  foreach($artefactList as $artefactValue){

                                    if(!empty($artefactValue['elements'])){

                                      foreach($artefactValue['elements'] as $element){

                                        Probe::deleteQuestion($element['id']);

                                      }                    
                                    }
                                  }

                                    // delete artefact info
                                    foreach($artefactList as $artefact){

                                      Probe::_delete($artefact['id']);

                                    } 

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                    $deletedData = TRUE;    

                                }    

                                    break;

                            case Config::get('constant.artefact.style_guide'):

                                $artefactList = StyleGuide::getStyleGuideByProject($projectId); 
                              
                                if(!empty($artefactList)){

                                  // delete artefact elements
                                  foreach($artefactList as $artefactValue){

                                      if(!empty($artefactValue['colors'])){

                                        foreach($artefactValue['colors'] as $color){

                                          StyleGuide::deleteColor($color['id']);

                                        }                    
                                      }

                                      if(!empty($artefactValue['fonts'])){

                                        foreach($artefactValue['fonts'] as $font){

                                          StyleGuide::deleteFont($font['id']);

                                        }                    
                                      }
                                    }                        

                                    // delete artefact info
                                    foreach($artefactList as $artefact){

                                      StyleGuide::deleteStyleGuide($artefact['id']);

                                    } 

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                    $deletedData = TRUE;    

                                } 

                                break;

                            case Config::get('constant.artefact.existing_system'):

                               $artefactList = ExistingSystem::getExistingSystemDataByProject($projectId); 

                                if(!empty($artefactList)){

                                  // delete artefact elements
                                  foreach($artefactList as $artefactValue){

                                    if(!empty($artefactValue['elements'])){

                                      foreach($artefactValue['elements'] as $element){

                                        ExistingSystem::deleteElement($element['id']);

                                      }                    
                                    }
                                  }

                                    // delete artefact info
                                    foreach($artefactList as $artefact){

                                      ExistingSystem::_delete($artefact['id']);

                                    } 

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                    $deletedData = TRUE;    

                                }                 

                                    break;

                            case Config::get('constant.artefact.checklist'):

                               $artefactList = Checklist::getChecklistsByProject($projectId);

                                if(!empty($artefactList)){

                                  // delete artefact elements
                                  foreach($artefactList as $artefactValue){

                                    if(!empty($artefactValue['elements'])){

                                      foreach($artefactValue['elements'] as $element){

                                          Checklist::deleteChecklitsElement($element['id']);

                                      }
                                    }                    
                                  }

                                    // delete artefact info
                                    foreach($artefactList as $artefact){

                                      Checklist::deleteChecklist($artefact['id']);

                                    } 

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact - project
                                    Artefact::deleteProjectArtefact($projectArtefact['id'], $projectId);

                                    $deletedData = TRUE;    

                                }  

                                  break;
                      } 


                      // delete iterations info
                      if(!empty($iterations)){
                        foreach($iterations as $iteration){

                          // delete user invitations
                          Iteration::deleteUsers($iteration['id']); 
                          Iteration::deleteIterationInvitations($iteration['id']);
                          Iteration::_delete($iteration['id']); 

                        }
                      }


                      // delete project info 
                      Project::_delete($projectId);                      
                                                 
                                
                }

              }

          }

              Session::flash('success_message', 'Se ha eliminado el proyecto correctamente'); 

              return Redirect::to(URL::action('DashboardController@index'));
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