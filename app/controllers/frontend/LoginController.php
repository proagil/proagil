<?php

class LoginController extends BaseController {

	public function index(){

    if(!is_null(Session::get('user'))){

          return Redirect::to(URL::action('DashboardController@index'));

    }else{

      if(Input::has('_token')){

        // validation rules
        $rules =  array(
          'email'              => 'required|email',
          'password'           => 'required'
        );
        $values = Input::get('values');
          $validator = Validator::make(Input::get('values'), $rules);

          // get data from post input

           if(!$validator->fails()){

              $user = User::getUserByEmail($values['email']);

              if ($user != NULL && md5($values['password']) == $user->password){ 

                    $sessionUser = array(
                      'id'                => $user->id,
                      'first_name'        => $user->first_name,
                      'last_name'         => $user->last_name,
                      'twitter_account'   => $user->twitter_account,
                      'facebook_account'  => $user->facebook_account,
                      'email'             => $user->email,
                      'avatar_file'       => $user->avatar_file
                    );

                      // save logged user on session
                    Session::put('user', $sessionUser);

                    // redirect to dashboard 
                    return Redirect::to(URL::action('DashboardController@index'));

              }else{

                  return View::make('frontend.login.index')->with('error_message', 'Correo electr&oacute;nico o clave incorrectas');
              }

           }else{

              return View::make('frontend.login.index')->withErrors($validator)->with('values', $values);

           }

      }else{

        // first time 
        return View::make('frontend.login.index');
      } 

    }

	}

  public function forgotPassword(){

      if(Input::has('_token')){

        // validation rules
        $rules =  array(
          'email'              => 'required|email',
        );

            $validator = Validator::make(Input::get('values'), $rules);

           // get data from post input
            $values = Input::get('values');

           if(!$validator->fails()){

              $user = User::getUserByEmail($values['email']);

              if ($user != NULL){ 

                    // generate token and update this on user
                    $userToken = array(
                      'token'       => md5($values['email'].date('H:i:s'))
                    );

                    User::_update($user->id, $userToken); 

                    //send email to user with token
                  $emailData = array(
                    'user_name'     => $user->first_name,
                    'url_token'     => URL::to('/'). '/recuperar-contrasena/'. $userToken['token']

                  );

                // send email to activate account
                        Mail::send('frontend.email_templates.changePassword', 

                        $emailData, 

                        function($message) use ($user){

                      $message->to($user->email);
                      $message->subject('Cambio de Contraseña');
                  });                   


                    // render user list view
                    return View::make('frontend.login.forgotPassword')
                                ->with('success_message', 'Se ha enviado un correo electr&oacute;nico para recuperar su contrase&ntilde;a');


              }else{

                  return View::make('frontend.login.forgotPassword')
                                ->with('error_message', 'El correo electr&oacute;nico indicado no est&aacute; registrado');
              }

           }else{

              return View::make('frontend.login.forgotPassword')->withErrors($validator)->with('values', $values);

           }

      }else{

        // first time 
         return View::make('frontend.login.forgotPassword');
      } 

  }

  public function changePassword($token){

      $userValues = User::getUserByToken($token);

      if(!empty($userValues)){

        if(Input::has('_token')){

          // validation rules
          $rules =  array(
            'password'            => 'required',
            'repeat_password'     => 'required|same:password'
          );

              $validator = Validator::make(Input::get('values'), $rules);

             // get data from post input
              $values = Input::get('values');

             if(!$validator->fails()){

              $userPassword = array(
                  'token'         => NULL,
                  'password'      => md5($values['password'])
              );

                //update user
                User::_update($userValues->id, $userPassword);

                return View::make('frontend.login.changePassword')
                                ->with('success_message', 'Su contrase&ntilde;a ha sido actualizada correctamente')
                                ->with('token', $token);

             }else{

                return View::make('frontend.login.index')
                          ->withErrors($validator)
                          ->with('values', $values)
                          ->with('token', $token);

             }

        }else{

          // first time 
           return View::make('frontend.login.changePassword')->with('token', $token);
        }    

      }else{

           return Redirect::to(URL::action('LoginController@index'));

      }

  }

  public function logout(){

    // remove all session items
    Session::flush();

    return Redirect::to(URL::action('LoginController@index'));

  }  

}
