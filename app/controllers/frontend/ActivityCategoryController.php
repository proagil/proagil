<?php

class ActivityCategoryController extends BaseController {

  public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        if(is_null(Session::get('user'))){
          return Redirect::to(URL::action('LoginController@index'));
        }

      });
  }


  public function edit($projectId){

    $user = Session::get('user'); 
    $userRole = (array) User::getUserRoleOnProject($projectId, $user['id']);

    if(empty($userRole)){

      return Redirect::to(URL::action('DashboardController@index')); 

    }else{

        // get project data
        $project = (array) Project::get($projectId);
        $categories = ActivityCategory::get($projectId);

         if(Input::has('_token')){

            // get input valiues
            $values = Input::get('values');

            //update categories
            if(isset($values['category'])){

                foreach($values['category'] as $id => $category){

                    $editedCategory = array(
                        'name'      =>  $category
                    );

                    ActivityCategory::edit($id, $editedCategory);

                }

            }

            //insert new categories
            if(isset($values['new_category'])){

                foreach($values['new_category'] as $index => $category){

                    $newCategory = array(
                        'name'          => $category,
                        'project_id'    => $projectId, 
                        'iteration_id'  => 1 //TODO: ASIGNAR $iterationId
                    );

                    ActivityCategory::insert($newCategory);

                }              
              
            }

            // --

            // -- T O D O: Message

            // --

            return Redirect::to(URL::action('ProjectController@detail', array($projectId)));


       }else{

          return View::make('frontend.project.editActivityCategories')
                      ->with('categories', $categories)
                      ->with('project', $project)
                      ->with('projectId', $projectId); 

       }


    }

  }

  public function delete($categoryId, $projectId){

    if(ActivityCategory::_delete($categoryId)){

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


}