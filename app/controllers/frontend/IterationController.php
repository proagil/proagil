<?php

class IterationController extends BaseController {


 	public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        if(is_null(Session::get('user'))){
          return Redirect::to(URL::action('LoginController@index'));
        }

      }
  }

  public function addArtefact($projectId, $iterationId) {

    // $user = Session::get('user');

    // $activityInformation = (array) Activity::getActivityUserAndProject($activityId);

    // $projectId = $activityInformation['project_id'];

    // $abtpId = $activityInformation['abtp_id'];

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
          $newIteration = array(
              'project_id'      => $projectId,
              'artefact_id'     => $newIterationArtefact,
              'iteration_id'    => $iterationId
          );
          
        }

         Session::flash('success_message', 'Se agregó un nuevo artefacto'); 

        return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $iterationId .'/'. $projectId);
      }else{
        Session::flash('error_message', 'Ocurrió un problema al agregar un nuevo artefacto'); 

                // redirect to detail view
                return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $iterationId .'/'. $projectId);

      }
    
    }else{
        Session::flash('error_message', 'Ocurrió un problema al agregar un nuevo artefacto'); 
        // redirect to detail
        return Redirect::to(URL::to('/'). '/proyecto/detalle/'. $iterationId .'/'. $projectId);

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

  public function delete($projectId){

      // get user on session
      $user = Session::get('user');   

      $isOwner = Project::userIsOwner($user['id'], $projectId);

      // verify if user on session is owner of project
      if(empty($isOwner)) {

        return Redirect::to(URL::action('DashboardController@index'));

      }else{

          Project::deleteUsers($projectId); 
          Project::deleteCategoriesActivity($projectId); 

              // delete project activities
              $activities = Project::getActivitiesByProject($projectId); 

              if(!empty($activities)){

                foreach($activities as $activity){
                  Activity::deleteActivityComment($activity['activity_id']);
                  Activity::deleteProjectActivity($activity['activity_id'], $projectId);
                  Activity::deleteActivity($activity['activity_id']); 
                
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

                                      foreach($artefactList as $artefactValue){

                                        StormIdeas::deleteStormIdeas($artefactValue['id']);

                                      }  

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
                                                 
                                
                }

              }

          }

              Session::flash('success_message', 'Se ha eliminado el proyecto correctamente'); 

              return Redirect::to(URL::action('DashboardController@index'));
  }


}
=======
 	}	

	public function config($projectId) {

    //get project iterations

    $projectIterations = Iteration::getIterationsByProject($projectId); 



	}

}
>>>>>>> b75edc016212f2411ee7655c0e9ccdf6f10e7b83
