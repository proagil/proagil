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

           		// --- TODO

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
                'avatar'			=> (isset($imageId))?$imageId:'',
                'password'        	=> Hash::make($values['password']),
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
				return Redirect::to('/');
			}


		}else{
			//FIXME!!!
			// - - -
			// redirect
			echo 'token invalido'; 
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

	           		// save user avatar
	           		$imageId = $this->uploadAndResizeFile($avatar, 300, 300); 
	           	}

              $updateUser = array(
                'first_name'      	=> $values['first_name'],
                'last_name'       	=> $values['last_name'],
                'avatar'			=> (isset($imageId))?$imageId:$user['avatar'],
                'password'        	=> isset($values['password'])?Hash::make($values['password']):$user['password'],
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

                 // update user session
				return Redirect::to(URL::action('DashboardController@index'));

              }else{

              	// update on DB fail
                return View::make('frontend.user.edit')->with('error_message', 'No se ha podido editar el perfil');

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

	public function uploadAndResizeFile($file, $width, $height){

		// get client name and generate server name
		$clientName = $file->getClientOriginalName(); 
		$serverName = md5(time(). str_replace(' ', '_', $clientName)).'.'.$file->guessClientExtension();

		// move file into uploads folder and resize
		$file->move(public_path('uploads'), $serverName);
		$resizedFile = Image::make(sprintf(public_path('uploads/%s'), $serverName))->resize($width, $height)->save();

		// save image on database and generate file id
		if($resizedFile!=NULL){

			$fileValues = array(
				'client_name'		=> $clientName,
				'server_name'		=> $serverName 
			);

			return $fileId = Files::insert($fileValues); 
		}

			//Input::file('avatar')->guessClientExtension()
			// Input::file('avatar')->getClientSize()		

		}

}
