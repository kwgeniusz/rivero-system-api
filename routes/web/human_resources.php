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

Route::get('payrolltypes/', 'Web\PayRollTypeController@index');
Route::post('payrolltypes/post', 'Web\PayRollTypeController@store');
Route::put('payrolltypes/put/{id}', 'Web\PayRollTypeController@update');
Route::delete('payrolltypes/delete/{id}', 'Web\PayRollTypeController@destroy');

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
Route::get('periods/list/{id}', 'Web\PeriodsController@getPayrollType');
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
Route::get('staff/list/positions/{id}', 'Web\HrStaffController@comboPositions');
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
Route::put('periods/put/{id}', 'Web\PeriodsController@update');
Route::delete('payrollcontrol/{id}', 'Web\PayrollControlController@destroy');
