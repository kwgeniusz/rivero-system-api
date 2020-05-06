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