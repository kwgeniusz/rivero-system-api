<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => 'cors'], function(){
    Route::post('login', 'Api\AuthController@login');
    Route::get('user-session', 'Api\AuthController@session');//->middleware('permission:shop.index');
});

Route::group(['middleware' => ['auth:api']], function () {
// rutas protegidas

// rutas para las sesiones
Route::get('user-session', 'Api\AuthController@session');//->middleware('permission:shop.index');
Route::get('user-logout', 'Api\AuthController@logout');//->middleware('permission:shop.index');

// obtener compañias (uso global)
Route::get('country-company', 'Api\CountryCompanyController@contryCompany');

// llena el combo para mostrar los empleados (uso global)
Route::get('hr-employees/{country}/{company}', 'Web\HrLoansController@getEmployees');

// prestamos

});


// Prestamos
Route::get('hr-history-loans/{staff}', 'Web\HrLoansController@getHistoryLoans');
Route::get('net-salary/{staff}', 'Web\functionsRrhhController@netSalary');
Route::post('perm-trans', 'Web\PerTransController@store');
Route::post('perm-trans-pay', 'Web\HrLoansController@payLoans');


// login
Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

// Route::resource('clients', 'Api\ClientController',['only' => ['index','show']]);

// Route::resource('contracts', 'Api\ContractController',['only' => ['index','show']]);

// Route::resource('users', 'Api\UserController',['except' => ['create','edit']]);

// Route::apiResource('departamentos', 'DepartmentController');
// Route::apiResource('hr-employees', 'Web\HrLoansController');




// Route::post('login', 'Api\AuthController@login');