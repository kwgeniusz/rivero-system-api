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

Route::group(['middleware' => ['auth:api']], function () {
    // rutas protegidas

    // rutas para las sesiones
    Route::get('user-session', 'Api\AuthController@session');//->middleware('permission:shop.index');
    Route::get('user-logout', 'Api\AuthController@logout'); //->middleware('permission:shop.index');


    // obtener compañias (uso global)
    Route::get('country-company', 'Api\CountryCompanyController@contryCompany');

    ######## Combos #######
    // llena el combo para mostrar los empleados (uso global)
    Route::get('hr-employees/{country}/{company}', 'Web\HrLoansController@getEmployees');

    // llenar combo: Tipos de transaccion
    Route::get('combo-trans-type/{countryId}/{companyId}', 'Web\getCombosRrhhController@comboTransactionType'); 

    ######### Fin Combos #########

    // prestamos
    Route::post('perm-trans', 'Web\PerTransController@store');
    
    ######### Para reporte por transacciones en nomina ############
    // reporte por transaccion nomina
    Route::post('report-by-transaction', 'Web\printPayrollController@reportByTransactionPayrollController');
    
    // obtener payrollNumber, utilizado como uno de los parametros para el reporte por transaccion nomina
    Route::get('get-payroll-number/{countryId}/{companyId}/{dateFrom}/{dateTo}/{updatePeriod}', 'Web\PeriodsController@getPeriodReport');

    ##### FIn Para reporte por transacciones en nomina #########
});

// Prestamos
Route::get('hr-history-loans/{staff}', 'Web\HrLoansController@getHistoryLoans');
Route::get('net-salary/{staff}/{countryId}/{companyId}', 'Web\functionsRrhhController@netSalary');
Route::post('perm-trans-pay', 'Web\HrLoansController@payLoans');

// login
Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

// barCode
Route::get('barcode-create/{staff}', 'Api\BarcodeController@barcodeCreate');
