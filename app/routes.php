<?php

/*--------------------------------------------------*/
/*---------------ADMIN routes-----------------------*/
/*--------------------------------------------------*/

Route::any('/admin', 'AdminLoginController@index');

Route::any('/admin/cerrar-sesion', 'AdminLoginController@logout');

Route::any('/admin/inicio', 'AdminDashboardController@index');

Route::any('/admin/tipo-de-proyecto', 'AdminProjectTypeController@enumerate');

Route::any('/admin/tipo-de-proyecto/agregar', 'AdminProjectTypeController@add');

Route::any('/admin/tipo-de-proyecto/editar/{id}', 'AdminProjectTypeController@edit');

Route::any('/admin/tipo-de-proyecto/eliminar/{id}', 'AdminProjectTypeController@delete');


/*--------------------------------------------------*/
/*-------------FRONTEND routes----------------------*/
/*--------------------------------------------------*/

Route::any('/', 'LoginController@index');

Route::any('/cerrar-sesion', 'LoginController@logout');

Route::any('olvido-contrasena', 'LoginController@forgotPassword');

Route::any('recuperar-contrasena/{token}', 'LoginController@changePassword');

Route::any('registro', 'UserController@register');

Route::any('perfil/{id}', 'UserController@edit');

Route::any('registro/validar/{token}', 'UserController@validateRegister');

Route::any('proyecto/crear', 'ProjectController@create');

Route::any('proyecto/invitar', 'ProjectController@invitation');

Route::any('proyecto/validar-invitacion/{token}', 'ProjectController@validateInvitation');

Route::any('proyecto/detalle', 'ProjectController@detail');

Route::any('proyecto/editar/{id}', 'ProjectController@edit');

Route::any('inicio', 'DashboardController@index');


