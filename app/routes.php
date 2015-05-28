<?php

/*--------------------------------------------------*/
/*---------------ADMIN routes-----------------------*/
/*--------------------------------------------------*/

Route::any('/admin', 'AdminLoginController@index');

Route::any('/admin/cerrar-sesion', 'AdminLoginController@logout');

Route::any('/admin/inicio', 'AdminDashboardController@index');

Route::any('/admin/artefacto', 'AdminArtefactController@enumerate');

Route::any('/admin/artefacto/agregar', 'AdminArtefactController@add');

Route::any('/admin/artefacto/editar/{id}', 'AdminArtefactController@edit');

Route::any('/admin/artefacto/eliminar/{id}', 'AdminArtefactController@delete');


/*--------------------------------------------------*/
/*-------------FRONTEND routes----------------------*/
/*--------------------------------------------------*/

Route::any('/', 'LoginController@index');

Route::any('actividad/cambiar-estado/{activity_id}/{status_id}', 'ActivityController@changeStatus');

Route::any('actividad/comentar', 'ActivityController@commnet');

Route::any('actividad/eliminar-comentario/{comment_id}', 'ActivityController@deleteComment');

Route::any('actividad/reasignar/{activity_id}', 'ActivityController@reassign');

Route::any('artefacto/{friendly_url}/proyecto/{project_id}/iteracion/{iteracion_id}', 'ArtefactController@detail');

Route::any('artefacto/obtener-informacion/{artefact_id}', 'ArtefactController@getArtefactInfo');

Route::any('/cerrar-sesion', 'LoginController@logout');

Route::any('inicio', 'DashboardController@index');

Route::any('listas-de-comprobacion/crear/{project_id}/{iteration_id}', 'ChecklistController@create');

Route::any('listas-de-comprobacion/eliminar/{checklist_id}', 'ChecklistController@delete');

Route::any('listas-de-comprobacion/editar/{checklist_id}', 'ChecklistController@edit');

Route::any('listas-de-comprobacion/listado/{project_id}/{iteration_id}', 'ChecklistController@index');

Route::any('listas-de-comprobacion/mostrar/{checklist_id}', 'ChecklistController@show');

Route::any('listas-de-comprobacion/exportar/{checklist_id}', 'ChecklistController@export');

Route::any('listas-de-comprobacion/verificar/{checklist_id}', 'ChecklistController@verify');

Route::any('olvido-contrasena', 'LoginController@forgotPassword');

Route::any('perfil/{id}', 'UserController@edit');

Route::any('proyecto/crear', 'ProjectController@create');

Route::any('proyecto/invitar', 'ProjectController@invitation');

Route::any('proyecto/editar-invitaciones/{project_id}', 'ProjectController@editInvitation');

Route::any('proyecto/eliminar-usuario/{user_id}/{project_id}', 'ProjectController@deleteUserOnProject');

Route::any('proyecto/validar-invitacion/{token}', 'ProjectController@validateInvitation');

Route::any('proyecto/detalle/{project_id}/{iteration_id}', 'ProjectController@detail');

Route::any('proyecto/editar/{project_id}', 'ProjectController@edit');

Route::any('proyecto/editar-informacion/{project_id}', 'ProjectController@editInfo');

Route::any('proyecto/editar-iteraciones/{project_id}', 'IterationController@index');

Route::any('proyecto/eliminar/{project_id}', 'ProjectController@delete');

Route::any('proyecto/eliminar-artefacto/', 'ProjectController@deleteArtefact');

Route::any('proyecto/agregar-iteracion/', 'IterationController@create');

Route::any('proyecto/configurar-iteraciones/{project_id}', 'IterationController@config');

Route::any('proyecto/editar-iteracion/{iteration_id}', 'IterationController@edit');

Route::any('proyecto/configurar-categorias/{project_id}/{iteration_id}', 'ActivityCategoryController@edit');

Route::any('proyecto/eliminar-categorias/{category_id}/{project_id}', 'ActivityCategoryController@delete');

Route::any('proyecto/actividad/crear/{project_id}/{iteration_id}', 'ActivityController@create');

Route::any('proyecto/actividad/eliminar/{activity_id}', 'ActivityController@delete');

Route::any('proyecto/actividad/detalle/{activity_id}', 'ActivityController@detail');

Route::any('proyecto/actividad/editar/{activity_id}', 'ActivityController@edit');

Route::any('proyecto/iteracion/artefacto/{project_id}/{iteration_id}', 'IterationController@addArtefact');

Route::any('proyecto/iteracion/eliminar/{project_id}', 'IterationController@delete');

Route::any('recuperar-contrasena/{token}', 'LoginController@changePassword');

Route::any('registro', 'UserController@register');

Route::any('registro/validar/{token}', 'UserController@validateRegister');

Route::any('registro/validar-invitacion/{token}', 'UserController@validateRegisterInvitation');

Route::any('sondeo/listado/{project_id}/{iteration_id}', 'ProbeController@index');

Route::any('sondeo/crear/{project_id}/{iteration_id}', 'ProbeController@create');

Route::any('sondeo/guardar/', 'ProbeController@save');

Route::any('sondeo/editar/{probe_id}', 'ProbeController@edit');

Route::any('sondeo/generar/{probe_url}', 'PublicProbeController@show');

Route::any('sondeo/guardar/{probe_url}', 'PublicProbeController@save');

Route::any('sondeo/enviado/{probe_url}', 'PublicProbeController@send');

Route::any('sondeo/obtener-pregunta/{question_id}', 'ProbeController@getProbeElement');

Route::any('sondeo/guardar-pregunta', 'ProbeController@saveProbeElement');

Route::any('sondeo/obtener-opcion/{option_id}', 'ProbeController@getProbeOption');

Route::any('sondeo/guardar-opcion', 'ProbeController@saveProbeOption');

Route::any('sondeo/guardar-nueva-opcion', 'ProbeController@saveNewProbeOption');

Route::any('sondeo/eliminar-pregunta/{question_id}', 'ProbeController@deleteQuestion');

Route::any('sondeo/eliminar-opcion/{question_id}', 'ProbeController@deleteOption');

Route::any('sondeo/obtener-sondeo-informacion/{probe_id}', 'ProbeController@getProbeInfo');

Route::any('sondeo/guardar-sondeo-informacion', 'ProbeController@saveProbeInfo');

Route::any('sondeo/guardar-nueva-pregunta', 'ProbeController@saveNewQuestion');

Route::any('sondeo/eliminar/{probe_id}', 'ProbeController@deleteProbe');

Route::any('sondeo/resultados/{probe_id}', 'ProbeController@getProbeResults');

Route::any('sondeo/exportar/{probe_id}', 'ProbeController@export');

Route::any('tormenta-de-ideas/crear/{project_id}/{iteration_id}', 'StormIdeasController@create');

Route::any('tormenta-de-ideas/eliminar/{storm_ideas_id}', 'StormIdeasController@delete');

Route::any('tormenta-de-ideas/editar/{storm_ideas_id}', 'StormIdeasController@edit');

Route::any('tormenta-de-ideas/listado/{project_id}/{iteration_id}', 'StormIdeasController@index');

Route::any('tormenta-de-ideas/guardar-imagen/{storm_ideas_id}/{storm_ideas_name}', 'StormIdeasController@saveStormIdeasImage');

Route::any('analisis-sistemas-existentes/listado/{project_id}/{iteration_id}', 'ExistingSystemController@index');

Route::any('analisis-sistemas-existentes/crear/{project_id}/{iteration_id}', 'ExistingSystemController@create');

Route::any('analisis-sistemas-existentes/guardar/', 'ExistingSystemController@save');

Route::any('analisis-sistemas-existentes/detalle/{system_id}', 'ExistingSystemController@getExistingSystem');

Route::any('analisis-sistemas-existentes/editar/{system_id}', 'ExistingSystemController@edit');

Route::any('analisis-sistemas-existentes/exportar/{system_id}', 'ExistingSystemController@export');

Route::any('/analisis-sistemas-existente/obtener-caracteristica/{element_id}', 'ExistingSystemController@getElement');

Route::any('/analisis-sistemas-existente/guardar-elemento/', 'ExistingSystemController@saveElement');

Route::any('/analisis-sistemas-existente/eliminar/{system_id}', 'ExistingSystemController@deleteExistingSystem');

Route::any('/analisis-sistemas-existente/eliminar-observacion/{element_id}', 'ExistingSystemController@deleteElement');

Route::any('/analisis-sistemas-existente/editar-informacion/{system_id}', 'ExistingSystemController@getSystemInfo');

Route::any('/analisis-sistemas-existente/guardar-informacion/{system_id}', 'ExistingSystemController@saveSystemInfo');

Route::any('/analisis-sistemas-existente/guardar-nueva-observacion/', 'ExistingSystemController@saveNewElement');

Route::any('/evaluacion-heuristica/listado/{project_id}/{iteration_id}', 'HeuristicEvaluationController@index');

Route::any('/evaluacion-heuristica/crear/{project_id}/{iteration_id}', 'HeuristicEvaluationController@create');

Route::any('/evaluacion-heuristica/guardar/', 'HeuristicEvaluationController@save');

Route::any('/evaluacion-heuristica/detalle/{evaluation_id}', 'HeuristicEvaluationController@getEvaluation');

Route::any('/evaluacion-heuristica/exportar/{evaluation_id}', 'HeuristicEvaluationController@export');

Route::any('/evaluacion-heuristica/editar/{evaluation_id}', 'HeuristicEvaluationController@edit');

Route::any('/evaluacion-heuristica/obtener-problema/{element_id}', 'HeuristicEvaluationController@getElement');

Route::any('/evaluacion-heuristica/guardar-elemento/', 'HeuristicEvaluationController@saveElement');

Route::any('/evaluacion-heuristica/eliminar/{evaluation_id}', 'HeuristicEvaluationController@deleteEvaluation');

Route::any('/evaluacion-heuristica/eliminar-problema/{element_id}', 'HeuristicEvaluationController@deleteElement');

Route::any('/evaluacion-heuristica/editar-informacion/{evaluation_id}', 'HeuristicEvaluationController@getEvaluationInfo');

Route::any('/evaluacion-heuristica/guardar-informacion/', 'HeuristicEvaluationController@saveEvaluationInfo');

Route::any('/evaluacion-heuristica/guardar-nuevo-problema/', 'HeuristicEvaluationController@saveNewElement');

Route::any('/guia-de-estilos/listado/{project_id}/{iteration_id}', 'StyleGuideController@index');

Route::any('/guia-de-estilos/crear/{project_id}/{iteration_id}', 'StyleGuideController@create');

Route::any('/guia-de-estilos/guardar', 'StyleGuideController@save');

Route::any('/guia-de-estilos/editar/{style_guide_id}', 'StyleGuideController@edit');

Route::any('/guia-de-estilos/eliminar-color/{color_id}', 'StyleGuideController@deleteColor');

Route::any('/guia-de-estilos/detalle/{style_guide_id}', 'StyleGuideController@detail');

Route::any('/guia-de-estilos/exportar/{style_guide_id}', 'StyleGuideController@export');

Route::any('/guia-de-estilos/eliminar-fuente/{font_id}', 'StyleGuideController@deleteFont');

Route::any('/guia-de-estilos/eliminar/{style_guide_id}', 'StyleGuideController@deleteStyleGuide');


/*---------------ROUTES: Diagrams & Prototype---------------------*/

Route::any('/diagrama-de-casos-de-uso/{project_id}', 'UseCaseController@index');

Route::any('/diagrama-de-casos-de-uso/guardar', 'UseCaseController@saveDiagram');

Route::any('/diagrama-de-objetos-de-dominio/{project_id}', 'DomainObjectController@index');



