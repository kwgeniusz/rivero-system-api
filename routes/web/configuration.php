<?php

//ROUTES DE MODULO CONFIGURACION----------------------------------------------------------------------------


//CHANGE OFFICE
Route::get('change-office', function () {return view('module_configuration.changeoffice.index');})->name('changeOffice.index');
Route::post('change-office', 'Web\UserController@changeOffice')->name('changeOffice.update');
//PROJECTS DESCRIPTIONS********
Route::resource('projectDescriptions', 'Web\ProjectDescriptionController', ['except' => ['create']]);
//PROJECT USES*************
Route::resource('projectUses', 'Web\ProjectUseController', ['except' => ['create']]);
Route::get('projectUses/{projectUseId}/descriptions', 'Web\ProjectUseController@getProjectDescription');
//SERVICES********
// Route::resource('service', 'Web\ServiceController',['except' => ['create']]);

Route::resource('services', 'Web\ServiceController');
Route::resource('notes', 'Web\NoteController');
Route::resource('contactTypes', 'Web\ContactTypeController');
//INVOICE TEMPLATES********
Route::resource('serviceTemplates', 'Web\ServiceTemplateController');
//USERS
Route::resource('users', 'Web\UserController');
Route::resource('users/{userId}/Permissions', 'Web\UserController@permissionsOfUser');

Route::resource('roles', 'Web\RolController');
Route::resource('permissions', 'Web\PermissionController');
