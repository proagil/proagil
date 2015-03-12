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

Route::any('/admin/artefacto', 'AdminArtefactController@enumerate');

Route::any('/admin/artefacto/agregar', 'AdminArtefactController@add');

Route::any('/admin/artefacto/editar/{id}', 'AdminArtefactController@edit');

Route::any('/admin/artefacto/eliminar/{id}', 'AdminArtefactController@delete');


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

Route::any('registro/validar-invitacion/{token}', 'UserController@validateRegisterInvitation');

Route::any('proyecto/crear', 'ProjectController@create');

Route::any('proyecto/invitar', 'ProjectController@invitation');

Route::any('proyecto/editar-invitaciones/{project_id}', 'ProjectController@editInvitation');

Route::any('proyecto/eliminar-usuario/{user_id}/{project_id}', 'ProjectController@deleteUserOnProject');

Route::any('proyecto/validar-invitacion/{token}', 'ProjectController@validateInvitation');

Route::any('proyecto/detalle/{project_id}', 'ProjectController@detail');

Route::any('proyecto/editar/{project_id}', 'ProjectController@edit');

Route::any('proyecto/eliminar/{project_id}', 'ProjectController@delete');

Route::any('proyecto/configurar-categorias/{project_id}', 'ActivityCategoryController@edit');

Route::any('proyecto/eliminar-categorias/{category_id}/{project_id}', 'ActivityCategoryController@delete');

Route::any('proyecto/{project_id}/actividad/{activity_id}', 'ActivityController@detail');

Route::any('actividad/cambiar-estado/{activity_id}/{status_id}', 'ActivityController@changeStatus');

Route::any('proyecto/actividad/crear/{project_id}', 'ActivityController@create');

Route::any('actividad/comentar', 'ActivityController@commnet');

Route::any('actividad/eliminar-comentario/{comment_id}', 'ActivityController@deleteComment');

Route::any('artefacto/{friendly_url}', 'ArtefactController@detail');

Route::any('inicio', 'DashboardController@index');