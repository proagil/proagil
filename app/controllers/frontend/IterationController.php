<?php

class IterationController extends BaseController {


  public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        if(is_null(Session::get('user'))){
          return Redirect::to(URL::action('LoginController@index'));
        }

      });
  }

  public function index($projectId){

    // get info
    $projectIterations = Iteration::getIterationsByProject($projectId); 
    $project = (array) Project::get($projectId);

    //get user role
    $userRole = Session::get('user_role');


    if(!empty($projectIterations)){

          return View::make('frontend.iteration.index')
                ->with('projectIterations', $projectIterations)
                ->with('projectOwner', ($userRole['user_role_id']==Config::get('constant.project.owner'))?TRUE:FALSE)
                ->with('projectName', $project['name'])
                ->with('projectId', $projectId); 

    }else{

      return Redirect::to(URL::action('DashboardController@index'));

    }

  }

  public function create(){

    $artefacts = (array) Artefact::enumerate(); 
    $roles = User::getRoles(); 
    $project = (array) Project::get(Session::get('project')['id']);

     if(Input::has('_token')){

      // validation rules
      $rules =  array(
          'order'     => 'required',
          'name'      => 'required',
          'init_date' => 'required',
          'end_date'  => 'required'
      );

      // set validation rules to input values
      $validator = Validator::make(Input::get('values'), $rules);

      // get input valiues
      $values = Input::get('values');

      if(!$validator->fails()){

        $projectId = $values['project_id']; 

        $iterationInfo = array(
            'name'        => $values['name'],
            'order'       => $values['order'],
            'init_date'   => $values['init_date'],
            'end_date'    => $values['end_date'],
            'project_id'  => $projectId 
          );

        $newIterationId = Iteration::insert($iterationInfo);

        if($newIterationId>0){

          if(isset($values['artefacts']) && !empty($values['artefacts'])){

              foreach($values['artefacts'] as $artefact){

                $artefactInfo = array(

                  'project_id'    => $projectId,
                  'artefact_id'   => $artefact,
                  'iteration_id'  => $newIterationId
                );

                Artefact::insertProjectArtefact($artefactInfo);    

              }

          } // end if artefacts

          if(isset($values['colaborator']) && !empty($values['colaborator'])){

            // get iteration COLABORATORS 
            foreach($values['colaborator'] as $index => $colaborator){

                $email = $colaborator['email']; 

                $userInvitation = array(
                    'email'         => $colaborator['email'],
                    'project_id'    => $projectId,
                    'iteration_id'  => $newIterationId,
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
                      'project_name'    =>  $project['name'],
                      'iteration_name'  => $values['name']

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
                        'project_name'  =>  $project['name'],
                        'iteration_name'  => $values['name']

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


          }  // end if colaborators 

              $user = Session::get('user');    

              // save user on session as project iteratins OWNER
              $userRole = array(

                'user_role_id'        => Config::get('constant.project.owner'),
                'project_id'          => $projectId,
                'user_id'             => $user['id'],
                'iteration_id'        => $newIterationId 

              );

              // save user on session as project owner
              User::userBelongsToProject($userRole);

              Session::flash('success_message', 'Se ha creado la nueva iteraci&oacute;n en '. $project['name']); 

              // redirect to invitation view
              return Redirect::to(URL::action('DashboardController@index'));          


        }else{

              Session::flash('error_message', 'No se ha podido crear la iteraci&oacute;n en  '. $project['name']); 

              // redirect to invitation view
              return Redirect::to(URL::action('DashboardController@index'));          

        }


      }else{

          return View::make('frontend.iteration.create')
                ->with('artefacts', $artefacts)
                ->with('roles', $roles)
                ->with('projectName', $project['name'])
                ->with('projectId', $project['id']);        

      }


     }else{

          return View::make('frontend.iteration.create')
                ->with('artefacts', $artefacts)
                ->with('roles', $roles)
                ->with('projectName', $project['name'])
                ->with('projectId', $project['id']);


     }


  }

  public function edit($iterationId) {

    $roles = User::getRoles();
    $project = (array) Project::get(Session::get('project')['id']);
    $iteration = Iteration::get($iterationId); 

    $colaborators = Iteration::getColaboratorOnIteration($iterationId); 


    if(!empty($iteration)){

      if(Input::has('_token')){

        // validation rules
        $rules =  array(
            'order'     => 'required',
            'name'      => 'required',
            'init_date' => 'required',
            'end_date'  => 'required'
        );

        // set validation rules to input values
        $validator = Validator::make(Input::get('values'), $rules);

        // get input valiues
        $values = Input::get('values');

          if(!$validator->fails()){

            $iterationId = $values['iteration_id'];
            $projectId = $values['project_id'];            

              $iterationInfo = array(
                  'name'        => $values['name'],
                  'order'       => $values['order'],
                  'init_date'   => $values['init_date'],
                  'end_date'    => $values['end_date'],
                );

              Iteration::_update($iterationId, $iterationInfo);


              if(isset($values['colaborator']) && !empty($values['colaborator'])){

                // get iteration COLABORATORS 
                foreach($values['colaborator'] as $index => $colaborator){

                    $email = $colaborator['email']; 

                    $userInvitation = array(
                        'email'         => $colaborator['email'],
                        'project_id'    => $projectId,
                        'iteration_id'  => $IterationId,
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
                          'project_name'    =>  $project['name'],
                          'iteration_name'  => $values['name']

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
                            'project_name'  =>  $project['name'],
                            'iteration_name'  => $values['name']

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


              }  // end if colaborators   

              Session::flash('success_message', 'Se ha editado la iteraci&oacute;n'); 

              // redirect to iteration view
              return Redirect::to(URL::action('ProjectController@detail', array($projectId, $iterationId)));               


          }else{

              // error validation alde
              Session::flash('error_message', 'No se ha podido editar la iteraci&oacute;n'); 

              // redirect to iteration view
              return Redirect::to(URL::action('ProjectController@detail', array($projectId, $iterationId)));   

          }

      }else{

        // first time
        return View::make('frontend.iteration.edit')
                    ->with('iterationId', $iterationId)
                    ->with('projectId', $project['id'])
                    ->with('values', $iteration)
                    ->with('roles', $roles)
                    ->with('colaborators', $colaborators);

      }


    }else{

       return Redirect::to(URL::action('LoginController@index'));

    }
  

  }  

  public function addArtefact($projectId, $iterationId) {

    if(Input::has('_token')){
    
      // validation rules
      $rules =  array(
          'artefacts'    => 'required'
      );

      // set validation rules to input values
      $validator = Validator::make(Input::get('values'), $rules);

      // get input valiues
      $values = Input::get('values');

      if(!$validator->fails()){

        $newIterationArtefacts = $values['artefacts'];
        foreach ($newIterationArtefacts as $newIterationArtefact) {
          $newIterationArtefact = array(
              'project_id'      => $projectId,
              'artefact_id'     => $newIterationArtefact,
              'iteration_id'    => $iterationId
          );
          Artefact::insertProjectArtefact($newIterationArtefact);          
        }

         Session::flash('success_message', 'Se agreg&oacute; un nuevo artefacto'); 

        return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId .'/'. $iterationId);
      }else{
        Session::flash('error_message', 'Ocurri&oacute; un problema al agregar un nuevo artefacto'); 

                // redirect to detail view
                return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId .'/'. $iterationId);

      }
    
    }else{
        Session::flash('error_message', 'Ocurri&oacute; un problema al agregar un nuevo artefacto'); 
        // redirect to detail
        return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $projectId .'/'. $iterationId);

    }

  }

  public function deleteArtefact(){

    $values = Input::get('values');

    $artefact = Artefact::getByFriendlyUrl($values['artefact_friendly_url']);

    $deletedData = FALSE; 

          if(!empty($artefact)){  

             switch($values['artefact_friendly_url']) {

                  case Config::get('constant.artefact.heuristic_evaluation'):

                     $artefactList = HeuristicEvaluation::getEvaluationDataByProject($values['project_id']); 

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
                          Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact - project
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                          $deletedData = TRUE;    

                      } 

                        break;

                  case Config::get('constant.artefact.storm_ideas'):

                      $artefactList = StormIdeas::enumerate($values['project_id']); 
                    
                      if(!empty($artefactList)){

                        // delete artefact 
                        foreach($artefactList as $artefactValue){

                          if(!empty($artefactValue)){

                            foreach($artefactList as $artefactValue){

                              StormIdeas::deleteStormIdeas($artefactValue['id']);

                            }  

                          }                  
                                        
                        }

                          //delete relation artefact - project
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact - project
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                          $deletedData = TRUE;    

                      } 

                          break; 

                  case Config::get('constant.artefact.probe'):

                     $artefactList = Probe::getProbeElementsByProject($values['project_id']); 

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
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact - project
                          Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                          $deletedData = TRUE;    

                      }    

                          break;

                  case Config::get('constant.artefact.style_guide'):

                      $artefactList = StyleGuide::getStyleGuideByProject($values['project_id']); 
                    
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
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact - project
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                          $deletedData = TRUE;    

                      } 

                      break;

                  case Config::get('constant.artefact.existing_system'):

                     $artefactList = ExistingSystem::getExistingSystemDataByProject($values['project_id']); 

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
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact - project
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                          $deletedData = TRUE;    

                      }                 

                          break;

                  case Config::get('constant.artefact.checklist'):

                     $artefactList = Checklist::getChecklistsByProject($values['project_id']);

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
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

                           $deletedData = TRUE;                        

                      }else{

                          //delete relation artefact - project
                           Artefact::deleteProjectArtefact($values['artefact_id'], $values['project_id']);

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

  public function delete($iterationId){

      // get user on session
      $user = Session::get('user');   

      $isOwner = Iteration::userIsOwner($user['id'], $iterationId);

      // verify if user on session is owner of project
      if(empty($isOwner)) {

        return Redirect::to(URL::action('DashboardController@index'));

      }else{

        $iteration = Iteration::get($iterationId);

        $IterationProjectId = $iteration['project_id']; 


              // delete iteration activities
              $activities = Project::getIterationActivities($iterationId); 

              if(!empty($activities)){

                foreach($activities as $activity){
                  Activity::deleteActivityComment($activity['activity_id']);
                  Activity::deleteIterationActivity($activity['activity_id'], $iterationId);
                  Activity::deleteActivity($activity['activity_id']); 
                
                }

              }

              // get iteration artefacts
              $iterationArtefacts = (array) Iteration::getArtefactsByIteration($iterationId, 'ALL'); 

              if(!empty($iterationArtefacts)){

                foreach($iterationArtefacts as $index => $iterationArtefact){

                       switch($iterationArtefact['friendly_url']) {

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
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

                                     $deletedData = TRUE;                        

                                }else{

                                  //delete relation artefact -iteration
                                  Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

                                    $deletedData = TRUE;    

                                } 

                                  break;

                            case Config::get('constant.artefact.storm_ideas'):

                                $artefactList = StormIdeas::enumerate($iterationId); 
                              
                                if(!empty($artefactList)){

                                  // delete artefact 
                                  foreach($artefactList as $artefactValue){

                                    if(!empty($artefactValue)){

                                      foreach($artefactList as $artefactValue){

                                        StormIdeas::deleteStormIdeas($artefactValue['id']);

                                      }  

                                    }                  
                                                  
                                  }

                                    //delete relation artefact -iteration
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact -iteration
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

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
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

                                     $deletedData = TRUE;                        

                                }else{

                                   //delete relation artefact -iteration
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

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
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

                                     $deletedData = TRUE;                        

                                }else{

                                   //delete relation artefact -iteration
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

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
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact -iteration
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

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
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

                                     $deletedData = TRUE;                        

                                }else{

                                    //delete relation artefact -iteration
                                    Artefact::deleteIterationArtefact($iterationArtefact['id'], $iterationId);

                                    $deletedData = TRUE;    

                                }  

                                  break;
                      }                       
                                                 
                                
                }

              }

          }
              // delete user invitations
              Iteration::deleteIterationInvitations($iterationId);

              // delete users on iteration
              Iteration::deleteUsers($iterationId); 


              if(Iteration::_delete($iterationId)){

                  Session::flash('success_message', 'Se ha eliminado la iteraci&oacute;n correctamente'); 

                  return Redirect::to(URL::action('IterationController@index', array($IterationProjectId)));
              }else{

                  Session::flash('error_message', 'No se pudo eliminar la iteraci&oacute;n'); 

                  return Redirect::to(URL::action('IterationController@index', array($IterationProjectId)));
              } 


  }

}

