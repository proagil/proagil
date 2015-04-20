<?php

class UserController extends BaseController {

	public function register(){

		if(Input::has('_token')){

	        // validation rules
	        $rules =  array(
	          'first_name'         	=> 'required',
	          'last_name'          	=> 'required',
	          'email'				=> 'required|email',
	          'password'           	=> 'required',
	          'repeat_password'    	=> 'required|same:password'
	        );

	        // set validation rules to input values
	        $validator = Validator::make(Input::get('values'), $rules);

	        // get input valiues
	        $values = Input::get('values');

           	if(!$validator->fails()){

           		// validate email doesn't exist on DB
				if(!empty(User::getUserByEmail($values['email']))){
	                
	                 return View::make('frontend.user.register')
	                 			->withErrors($validator)
	                 			->with('values', $values)
	                 			->with('error_message', 'El correo electr&oacute;nico especificado ya est&aacute; registrado');

				}else{

		           	// get user avatar
		           	$avatar = Input::file('avatar');

		           	if($avatar!=NULL){

		           		// save user avatar
		           		$imageId = $this->uploadAndResizeFile($avatar, 300, 300); 
		           	}

	              $user = array(
	                'first_name'      	=> $values['first_name'],
	                'last_name'       	=> $values['last_name'],
	                'email'           	=> $values['email'],
	                'avatar'			=> (isset($imageId))?$imageId:NULL,
	                'password'        	=> md5($values['password']),
	                'enabled'		  	=> Config::get('constant.NOT_ENABLED'),
	                'token'				=> md5($values['email'].date('H:i:s'))
	              );

	              // insert user on DB
	              if(User::insert($user)>0){

	              	// create email data
	              	$emailData = array(
	              		'user_name'			=> $user['first_name'],
	              		'url_token'			=> URL::to('/'). '/registro/validar/'. $user['token']

	              	);

					// send email to activate account
	              	Mail::send('frontend.email_templates.register', 

	              	$emailData, 

	              	function($message) use ($user){

	        			$message->to($user['email']);
	        			$message->subject('Confirmar registro');
	    			});


	                Session::flash('success_register', 'Se ha registrado exitosamente, revise su correo para validar el registro'); 
	                
	                return Redirect::to(URL::action('LoginController@index'));

	              }else{

	                 return View::make('frontend.user.register')
	                 			->with('error_message', 'No se pudo realizar el registro')
	                 			->with('values', $values);
	                
	              }					

				}


           	}else{

              return View::make('frontend.user.register')->withErrors($validator)->with('values', $values);

           	}

	      }else{

	        // render view first time 
	        return View::make('frontend.user.register');
	      }

	}

	public function validateRegister($token) {

		$userValues = User::getUserByToken($token);

		if(!empty($userValues)){

			$user = array(
				'token'		=>	NULL,
				'enabled'	=>	Config::get('constant.ENABLED')

			);

			if(User::_update($userValues->id, $user)){

				// get user register invitation and insert user on project
				if(Session::get('project_invitation')!=NULL){

					$invitation = Session::get('project_invitation');

			        $userRole = array(

			          'user_role_id'        => $invitation['user_role_id'],
			          'project_id'          => $invitation['project_id'],
			          'user_id'             => $userValues->id

			        );

			        // get project name
			        $project = (array) Project::get($invitation['project_id']); 

			        // save user as project member
			        User::userBelongsToProject($userRole);    

			        Session::flash('success_message', 'Ya eres parte del proyecto: '. $project['name'].'.Inicia sesi&oacute;n para acceder a &eacute;l'); 					

				}else{

					Session::flash('success_message', 'Se ha validado tu correo electr&oacute;nico. Ya puedes iniciar sesi&oacute;'); 					

				}

					return Redirect::to(URL::action('LoginController@index'));
			}


		}else{
 			
 			return Redirect::to(URL::action('LoginController@index'));
		}


	}

	public function validateRegisterInvitation($token) {

		$invitation = (array) User::getInvitationByToken($token);

	    if(empty($invitation)){

	        return Redirect::to(URL::action('LoginController@index'));

	    }else{

	    		// save invitation on session
		    	Session::put('project_invitation', $invitation);

			if(Input::has('_token')){

		        // validation rules
		        $rules =  array(
		          'first_name'         	=> 'required',
		          'last_name'          	=> 'required',
		          'email'				=> 'required|email',
		          'password'           	=> 'required',
		          'repeat_password'    	=> 'required|same:password'
		        );

		        // set validation rules to input values
		        $validator = Validator::make(Input::get('values'), $rules);

		        // get input valiues
		        $values = Input::get('values');

	           	if(!$validator->fails()){

	           		// validate email doesn't exist on DB
					if(!empty(User::getUserByEmail($values['email']))){
		                
		                 return View::make('frontend.user.register')
		                 			->withErrors($validator)
		                 			->with('values', $values)
		                 			->with('error_message', 'El correo electr&oacute;nico especificado ya est&aacute; registrado');

					}else{

			           	// get user avatar
			           	$avatar = Input::file('avatar');

			           	if($avatar!=NULL){

			           		// save user avatar
			           		$imageId = $this->uploadAndResizeFile($avatar, 300, 300); 
			           	}

		              $user = array(
		                'first_name'      	=> $values['first_name'],
		                'last_name'       	=> $values['last_name'],
		                'email'           	=> $values['email'],
		                'avatar'			=> (isset($imageId))?$imageId:NULL,
		                'password'        	=> md5($values['password']),
		                'enabled'		  	=> Config::get('constant.NOT_ENABLED'),
		                'token'				=> md5($values['email'].date('H:i:s'))
		              );

		              // insert user on DB
		              if(User::insert($user)>0){

		              	// create email data
		              	$emailData = array(
		              		'user_name'			=> $user['first_name'],
		              		'url_token'			=> URL::to('/'). '/registro/validar/'. $user['token']

		              	);

						// send email to activate account
		              	Mail::send('frontend.email_templates.register', 

		              	$emailData, 

		              	function($message) use ($user){

		        			$message->to($user['email']);
		        			$message->subject('Confirmar registro');
		    			});


		                Session::flash('success_register', 'Se ha registrado exitosamente, revise su correo para validar el registro'); 

		                // delete token on invitation
        				User::updateInvitation($invitation['id'], array('token'=>NULL)); 
		                
		                return Redirect::to(URL::action('LoginController@index'));

		              }else{

		                 return View::make('frontend.user.register')
		                 			->with('error_message', 'No se pudo realizar el registro')
		                 			->with('values', $values);
		                
		              }					

					}


	           	}else{

	              return View::make('frontend.user.registerInvitation')->withErrors($validator)->with('values', $values);

	           	}

		      }else{

		        // render view first time 
		        return View::make('frontend.user.registerInvitation')->with('values', $invitation);
		      }

	    }

	}

	public function edit($userId) {

		$user = (array) User::getUserById($userId);

		if(Input::has('_token')){

			// get input valiues
	        $values = Input::get('values');

	        // validation rules
	        $rules =  array(
	          'first_name'         	=> 'required',
	          'last_name'          	=> 'required',
	        );

	        if($values['password']!=NULL || $values['password'] != '') {
	        	$rules['password'] = 'required';
	        	$rules['repeat_password'] = 'required|same:password'; 
	        }

	        // set validation rules to input values
	        $validator = Validator::make(Input::get('values'), $rules);

           	if(!$validator->fails()){

	           	// get user avatar
	           	$avatar = Input::file('avatar');

	           	if($avatar!=NULL){

	           		// save new user avatar
	           		$imageId = $this->uploadAndResizeFile($avatar, 300, 300); 

	           		// delete old avatar
	           		if($user['avatar']!=NULL || $user['avatar']!=''){
	           			$this->deleteFile($user['avatar_file'], $user['avatar']); 
	           		}

	           	}

              $updateUser = array(
                'first_name'      	=> $values['first_name'],
                'last_name'       	=> $values['last_name'],
                'avatar'			=> (isset($imageId))?$imageId:$user['avatar'],
                'password'        	=> ($values['password']!=NULL)?md5($values['password']):$user['password'],
              );

              // update user on DB
              if(User::_update($user['id'], $updateUser)){

                $editedUser = User::getUserById($userId);

                 $sessionUser = array(
	                  'id'                => $editedUser->id,
	                  'first_name'        => $editedUser->first_name,
	                  'last_name'         => $editedUser->last_name,
	                  'twitter_account'   => $editedUser->twitter_account,
	                  'facebook_account'  => $editedUser->facebook_account,
	                  'email'             => $editedUser->email,
	                  'avatar_file'       => $editedUser->avatar_file
                   );


                 Session::put('user', $sessionUser);

                 Session::flash('success_message', 'Se editó su perfil'); 

                 // update user session
				return Redirect::to(URL::action('DashboardController@index'));

              }else{

              	// update on DB fail
                return View::make('frontend.user.edit')->with('error_message', 'No se editó el perfil');

              }

           	}else{

           		// validation fails
              return View::make('frontend.user.edit')
              			->withErrors($validator)
              			->with('values', $user)
              			->with('userId', $userId);
           	}

	      }else{

	        // render view first time 
	        return View::make('frontend.user.edit')
	        			->with('userId', $userId)
	        			->with('values', $user); 
	      }		

	}

	public function uploadAndResizeFile($file, $width, $height) {

		// get client name and generate server name
		$clientName = $file->getClientOriginalName(); 
		$serverName = md5(time(). str_replace(' ', '_', $clientName)).'.'.$file->guessClientExtension();

		// move file into uploads folder and resize
		$file->move(public_path('uploads'), $serverName);
		$resizedFile = Image::make(sprintf(public_path('uploads/%s'), $serverName))->widen($width)->save();

		// save image on database and generate file id
		if($resizedFile!=NULL){

			$fileValues = array(
				'client_name'		=> $clientName,
				'server_name'		=> $serverName 
			);

			return $fileId = Files::insert($fileValues); 
		}

	}

	public function deleteFile($fileName, $fileId){

		$fileDeleted = FALSE; 

		if(unlink(sprintf(public_path('uploads/%s'), $fileName))){
			if(Files::_delete($fileId)){
				$fileDeleted = TRUE; 
			} 
		}

		return $fileDeleted; 
	}

}
