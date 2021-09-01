<?php


Route::get('departments/', 'DepartmentController@index');
Route::get('departments/parent', 'DepartmentController@parent');
Route::get('departments/company', 'DepartmentController@searchCompany');
Route::get('departments/edit/{id}', 'DepartmentController@editDepartment');
Route::put('departments/update/{id}', 'DepartmentController@updateHard');
Route::post('departments/', 'DepartmentController@store');
Route::put('departments/{id}', 'DepartmentController@update');
Route::delete('departments/{id}', 'DepartmentController@destroy');

// department
Route::get('department/', function () {
    return view('rrhh.department.index');
})->name('departments.index');

// payroll type
Route::get('payrolltype/', function () {
    return view('rrhh.payroll_type.index');
})->name('payroll_type.index');

Route::get('payrolltypes/', 'Web\PayrollTypeController@index');
Route::post('payrolltypes/post', 'Web\PayrollTypeController@store');
Route::put('payrolltypes/put/{id}', 'Web\PayrollTypeController@update');
Route::delete('payrolltypes/delete/{id}', 'Web\PayrollTypeController@destroy');

// position
Route::get('charges/', function () {
    return view('rrhh.position.index');
})->name('charges.index'); 
Route::get('hrposition/', 'Web\HrPositionController@index');
Route::post('hrposition/post', 'Web\HrPositionController@store');
Route::put('hrposition/put/{id}', 'Web\HrPositionController@update');
Route::delete('hrposition/delete/{id}', 'Web\HrPositionController@destroy');

// transaction type
Route::get('transactionstype/', function () {
    return view('rrhh.transactions_type.index');
})->name('transactions_type.index'); 
Route::get('transactionstypes/', 'Web\HrTransactionTypeController@index');
Route::post('transactionstypes/post', 'Web\HrTransactionTypeController@store');
Route::put('transactionstypes/put/{id}', 'Web\HrTransactionTypeController@update');
Route::delete('transactionstypes/delete/{id}', 'Web\HrTransactionTypeController@destroy');

// Periods
Route::get('periods/', function () {
    return view('rrhh.periods.index');
})->name('periods.index'); 
Route::get('periods/list/', 'Web\PeriodsController@index');
// Route::get('periods/list/{id}', 'Web\PeriodsController@getPayrollType');
Route::get('periods/list/{year}/{month}', 'Web\PeriodsController@generatePeriods');
Route::get('periods/payrollNumber/{country}/{company}/{payrollType}/{year}', 'Web\PeriodsController@getPayrollNumber');
Route::post('periods/post', 'Web\PeriodsController@store');
Route::put('periods/put/{id}', 'Web\PeriodsController@update');
Route::delete('periods/delete/{id}', 'Web\PeriodsController@destroy');

// Process
Route::get('process/', function () {
    return view('rrhh.process.index');
})->name('process.index'); 
Route::get('process/list/', 'Web\ProcessController@index');
Route::post('process/post', 'Web\ProcessController@store');
Route::put('process/put/{id}', 'Web\ProcessController@update');
Route::delete('process/delete/{id}', 'Web\ProcessController@destroy');
// --> process Detaill
Route::get('process-detail/{id}', 'Web\ProcessController@processDetail');
Route::get('process-detail-ttype/{id}', 'Web\ProcessController@processTransactionType');
Route::post('process-detail/post', 'Web\ProcessController@storeDetail');
Route::put('process-detail/{id}', 'Web\ProcessController@updateDetail');
Route::delete('process-detail/{id}', 'Web\ProcessController@destroyDetail');

// staff
Route::get('staff/', function () {
    return view('rrhh.staff.index');
})->name('staff.index'); 
Route::get('staff/list/', 'Web\HrStaffController@index');
Route::get('staff/list/combox/', 'Web\HrStaffController@comboBoxMult');
Route::get('staff/list/comboxDepartment/{id}', 'Web\HrStaffController@comboBoxDeparmet');
Route::get('staff/list/typepayroll/{id}', 'Web\HrStaffController@comboTypePayroll');
Route::get('staff/list/positions', 'Web\HrStaffController@comboPositions');
Route::post('staff/post', 'Web\HrStaffController@store');
Route::put('staff/put/{id}', 'Web\HrStaffController@update');
Route::delete('staff/delete/{id}', 'Web\HrStaffController@destroy');

// payroll Controll
Route::get('payrollcontrol/', function () {
    return view('rrhh.payrollcontrol.index');
})->name('payrollcontrol.index'); 
Route::get('payrollcontrol/list/', 'Web\PayrollControlController@index');
Route::get('payrollcontrol/payrollNumber/{country}/{company}/{payrollType}/{year}', 'Web\PayrollControlController@getPayrollNumber');
Route::get('payrollcontrol/process/{country}/{company}', 'Web\PayrollControlController@getPorcess');
Route::get('payrollcontrol/list/{id}', 'Web\PayrollControlController@processPrePayroll');
Route::post('payrollcontrol', 'Web\PayrollControlController@store');
// Route::put('periods/put/{id}', 'Web\PeriodsController@update');
Route::delete('payrollcontrol/{id}', 'Web\PayrollControlController@destroy');

// imprimir pre-nomina
Route::get('print-pre-payroll/', function () {
    return view('rrhh.printPrePayroll.index');
})->name('printprepayroll.index'); 
Route::get('pre-payroll-all/', 'Web\printPrePayrollController@index');
Route::get('pre-payroll-all/list/{countryId}/{companyId}/{year}/{payrollNumber}/{payrollTypeId}', 'Web\printPrePayrollController@getListPrePayroll');
Route::get('pre-payroll-all/detail/{countryId}/{companyId}/{year}/{payrollNumber}/{staffCode}', 'Web\printPrePayrollController@getListDetail');
// imprimir nomina
Route::get('print-payroll/', function () {
    return view('rrhh.print-payroll.index');
})->name('print-payroll.index'); 
Route::get('print-payroll/list/', 'Web\printPayrollController@index');
Route::get('print-payroll/show/{countryId}/{companyId}/{year}/{payrollNumber}/{payrollTypeId}', 'Web\printPayrollController@getPayrollShow');


// permanent transaction
Route::get('permanent-trans/', function () {
    return view('rrhh.permanetTranction.index');
})->name('permanent-trans.index'); 
Route::get('list-perm-trans/', 'Web\PerTransController@index');
Route::post('perm-trans', 'Web\PerTransController@store');
Route::put('perm-trans/{id}', 'Web\PerTransController@update');
Route::delete('perm-trans/{id}', 'Web\PerTransController@destroy');

// Update payroll
Route::get('update-payroll/', function () {
    return view('rrhh.update-payroll.index');
})->name('update-payroll.index'); 
Route::get('list-payroll-history/', 'Web\PayrollHistoryController@index');
Route::get('payrollhistoryl/process/{countryId}/{companyId}/{year}/{payrollNumber}/{payrollTypeId}', 'Web\PayrollHistoryController@processPayrollHistory');


// combosBox
Route::get('combo-staff/{countryId}/{companyId}', 'Web\getCombosRrhhController@comboStaff');
Route::get('combo-trans-type/{countryId}/{companyId}', 'Web\getCombosRrhhController@comboTransactionType');

// salarios netos
Route::get('net-salary/{staff}', 'Web\functionsRrhhController@netSalary');

// Payment receipt
Route::get('payment-receipt/', function () {
    return view('rrhh.paycheck.index');
})->name('paycheck.index'); 
Route::get('staff-receipt', 'Web\functionsRrhhController@paymenSalary');
Route::get('history-receipt/{staff}', 'Web\functionsRrhhController@historyReceipt');
