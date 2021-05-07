<?php

//ROUTES DE MODULO CONFIGURACION----------------------------------------------------------------------------

//CHANGE OFFICE
Route::get('change-company', function () {return view('module_configuration.changecompany.index'); })->name('changeCompany.index');
Route::post('change-company', 'Web\UserController@changeCompany')->name('changeCompany.update');
//BUILDING CODES*************
Route::get('buildingCode', 'Web\BuildingCodeController@index')->name('buildingCode.index');
Route::get('buildingCode/{id}/groups', 'Web\BuildingCodeController@getGroups');
//PROJECT USES*************
Route::resource('projectUses', 'Web\ProjectUseController', ['except' => ['create']]);
Route::get('projectUses/{projectUseId}/descriptions', 'Web\ProjectUseController@getProjectDescription');
//PROJECTS DESCRIPTIONS********
Route::resource('projectDescriptions', 'Web\ProjectDescriptionController', ['except' => ['create']]);
//SERVICES********
Route::resource('services', 'Web\ServiceController');
Route::resource('notes', 'Web\NoteController', ['parameters' => ['notes' => 'id']]);

//INVOICE TEMPLATES********
Route::resource('serviceTemplates', 'Web\ServiceTemplateController');
//USERS
Route::resource('users', 'Web\UserController');
Route::get('users/{userId}/permissions', 'Web\UserController@permissionsOfUser')->name('users.permissions');
Route::post('users/{userId}/add/Permissions', 'Web\UserController@addPermissions')->name('users.add.permissions');

Route::resource('roles', 'Web\RolController');
Route::resource('permissions', 'Web\PermissionController');

// Configuration: Create company
Route::get('company/', function () {
    return view('module_configuration.company.index');
})->name('company.index');

Route::get('companys/', 'Web\CompanyController@index');
Route::get('companys/contrys', 'Web\CompanyController@comboContry');
Route::get('companys/contrys/{id}', 'Web\CompanyController@comboContryId');
Route::get('companys/offices/{id}', 'Web\CompanyController@combOffice');
Route::get('companys/show/{id}', 'Web\CompanyController@editCompany');
Route::post('companys/', 'Web\CompanyController@store');
Route::put('companys/{id}', 'Web\CompanyController@update');
Route::delete('companys/{id}', 'Web\CompanyController@destroy');

// currency
Route::get('currencys/list', 'Web\CurrencyController@index');

