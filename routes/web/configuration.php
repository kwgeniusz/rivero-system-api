<?php

//ROUTES DE MODULO CONFIGURACION----------------------------------------------------------------------------
//CHANGE OFFICE
Route::get('change-office', function () {return view('module_configuration.changeoffice.index');})->name('changeOffice.index');
Route::post('change-office', 'Web\UserController@changeOffice')->name('changeOffice.update');
//PROJECTS********
Route::resource('projectDescriptions', 'Web\ProjectDescriptionController', ['except' => ['create']]);
//SERVICES********
Route::resource('projectUses', 'Web\ProjectUseController', ['except' => ['create']]);
//USERS
Route::resource('users', 'Web\UserController');
Route::resource('users/{userId}/Permissions', 'Web\UserController@permissionsOfUser');

Route::resource('roles', 'Web\RolController');
Route::resource('permissions', 'Web\PermissionController');
