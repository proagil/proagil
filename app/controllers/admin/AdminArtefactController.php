<?php

class AdminArtefactController extends AdminBaseController {

  public function __construct(){

      //not user on session
      $this->beforeFilter(function(){

        if(is_null(Session::get('admin_user'))){
          return Redirect::to(URL::action('AdminLoginController@index'));
        }

      });
  } 

	public function enumerate(){

		$entities = AdminArtefact::enumerate(); 

      	return View::make('admin.artefact.enumerate')->with('entities', $entities);

	}

	public function add(){

      if(Input::has('_token')){

        // validation rules
        $rules =  array(
          'name'         		=> 'required',
          'description'     => 'required'
        );

            $validator = Validator::make(Input::get('values'), $rules);

           // get data from post input
            $values = Input::get('values');

           if(!$validator->fails()){

            // generate friendly URL name
            $friendlyURLName = $this->friendlyURL($values['name']);

            // upload icon
            $imageId = $this->uploadFile(Input::file('icon')); 


              $entity = array(
                'name'       		        => $values['name'],
                'description'           => $values['description'],
                'enabled'               => isset($values['enabled'])?$values['enabled']:'0',
                'friendly_url'          => $friendlyURLName,
                'icon'                  => $imageId
              );

              // insert user on DB
              if(AdminArtefact::insert($entity)>0){

                return Redirect::to(URL::action('AdminArtefactController@enumerate'));

              }else{

                 return View::make('admin.artefact.add')->flash('message', Config::get('constant.admin.message.error').' '.Config::get('constant.admin.entity.project_type'))->with('values', $values);
                
              }

           }else{

              return View::make('admin.artefact.add')->withErrors($validator)->with('values', $values);

           }

      }else{

        // first time 
        return View::make('admin.artefact.add');
      }
		
	}

	public function edit($entity_id){

      if(Input::has('_token')){

        // validation rules
        $rules =  array(
          'name'            => 'required',
          'description'     => 'required'
        );

            $validator = Validator::make(Input::get('values'), $rules);

           // get data from post input
            $values = Input::get('values');

           if(!$validator->fails()){

            // generate friendly URL name
            $friendlyURLName = $this->friendlyURL($values['name']);


              $entity = array(
                'name'       		        => $values['name'],
                'description'           => $values['description'],
                'enabled'               => isset($values['enabled'])?$values['enabled']:'0',
                'friendly_url'          => $friendlyURLName,
              );


              // upload icon
              if(Input::file('icon')!=NULL){

                $imageId = $this->uploadFile(Input::file('icon')); 

                $entity['icon'] = $imageId;

              }

              // insert user on DB
              if(AdminArtefact::edit($entity_id, $entity)){

                return Redirect::to(URL::action('AdminArtefactController@enumerate'));

              }else{

                 return View::make('admin.artefact.add')->flash('message', Config::get('constant.admin.message.error').' '.Config::get('constant.admin.entity.project_type'))->with('values', $values);
                
              }

           }else{

              return View::make('admin.artefact.add')->withErrors($validator)->with('values', $values);

           }

      }else{

      	$values = AdminArtefact::get($entity_id);

        // first time 
        return View::make('admin.artefact.edit')->with('values', $values);
      }

	}

	public function delete($entity_id){

		if(AdminArtefact::_delete($entity_id)){

      return Redirect::to(URL::action('AdminArtefactController@enumerate'));

    }else{

      $entities = AdminArtefact::enumerate(); 

      // return with error message
      return View::make('admin.artefact.enumerate')
            ->with('error_message', 'No se pudo eliminar la entidad')
            ->with('entities', $entities);
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

  public function uploadFile($file){

    // get client name and generate server name
    $clientName = $file->getClientOriginalName(); 
    $serverName = md5(time(). str_replace(' ', '_', $clientName)).'.'.$file->guessClientExtension();

    // move file into uploads folder and resize
    $file->move(public_path('uploads'), $serverName);
    $uploadedFile = Image::make(sprintf(public_path('uploads/%s'), $serverName))->save();

    // save image on database and generate file id
    if($uploadedFile!=NULL){

      $fileValues = array(
        'client_name'   => $clientName,
        'server_name'   => $serverName 
      );

      return AdminFiles::insert($fileValues); 
    }

  }  



}
