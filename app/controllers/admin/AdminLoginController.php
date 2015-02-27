<?php

class AdminLoginController extends AdminBaseController {

	public function index(){

      if(Input::has('_token')){

        // validation rules
        $rules =  array(
          'email'              => 'required|email',
          'password'           => 'required'
        );

            $validator = Validator::make(Input::get('values'), $rules);

           // get data from post input
            $values = Input::get('values');

           if(!$validator->fails()){

              $adminUser = AdminLogin::getUserByEmail($values['email']);

              if ($adminUser != NULL && md5($values['password']) ==  $adminUser->password){ 

                    // save logged admin user on session
                    Session::put('admin_user', $adminUser);

                    // render user list view
                    return Redirect::to(URL::action('AdminDashboardController@index'));

              }else{

                  return View::make('admin.login.index')->with('error_message', 'Correo electr&oacute;nico o clave incorrectas');
              }

           }else{

              return View::make('admin.login.index')->withErrors($validator)->with('values', $values);

           }

      }else{

        // first time 
        return View::make('admin.login.index');
      }

	}

	public function logout(){

		// remove all session items
		Session::flush();

		return Redirect::to(URL::action('AdminLoginController@index'));

	}

}
