<?php

class AdminProjectTypeController extends AdminBaseController {

  public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        if(is_null(Session::get('admin_user'))){
          return Redirect::to(URL::action('AdminLoginController@index'));
        }

      });
  } 

	public function enumerate(){

		$entities = AdminProjectType::enumerate(); 

      	return View::make('admin.project_type.enumerate')->with('entities', $entities);

	}

	public function add(){

      if(Input::has('_token')){

        // validation rules
        $rules =  array(
          'name'         		=> 'required',
        );

            $validator = Validator::make(Input::get('values'), $rules);

           // get data from post input
            $values = Input::get('values');

           if(!$validator->fails()){

              $entity = array(
                'name'       		=> $values['name'],
                'enabled'        	=> isset($values['enabled'])?$values['enabled']:'0'
              );

              // insert user on DB
              if(AdminProjectType::insert($entity)>0){

                return Redirect::to(URL::action('AdminProjectTypeController@enumerate'));

              }else{

                 return View::make('admin.project_type.add')->flash('message', Config::get('constant.admin.message.error').' '.Config::get('constant.admin.entity.project_type'))->with('values', $values);
                
              }

           }else{

              return View::make('admin.project_type.add')->withErrors($validator)->with('values', $values);

           }

      }else{

        // first time 
        return View::make('admin.project_type.add');
      }
		
	}

	public function edit($entity_id){

      if(Input::has('_token')){

        // validation rules
        $rules =  array(
          'name'         		=> 'required',
        );

            $validator = Validator::make(Input::get('values'), $rules);

           // get data from post input
            $values = Input::get('values');

           if(!$validator->fails()){

              $entity = array(
                'name'       		=> $values['name'],
                'enabled'        	=> isset($values['enabled'])?$values['enabled']:'0'
              );

              // insert user on DB
              if(AdminProjectType::edit($entity_id, $entity)){

                return Redirect::to(URL::action('AdminProjectTypeController@enumerate'));

              }else{

                 return View::make('admin.project_type.add')->flash('message', Config::get('constant.admin.message.error').' '.Config::get('constant.admin.entity.project_type'))->with('values', $values);
                
              }

           }else{

              return View::make('admin.project_type.add')->withErrors($validator)->with('values', $values);

           }

      }else{

      	$values = AdminProjectType::get($entity_id);

        // first time 
        return View::make('admin.project_type.edit')->with('values', $values);
      }

	}

	public function delete($entity_id){

		if(AdminProjectType::_delete($entity_id)){

      return Redirect::to(URL::action('AdminProjectTypeController@enumerate'));

    }else{

      $entities = AdminProjectType::enumerate(); 

      // return with error message
      return View::make('admin.project_type.enumerate')
            ->with('error_message', 'No se pudo eliminar la entidad')
            ->with('entities', $entities);
    }


	}

}
