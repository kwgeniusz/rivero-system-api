<?php

//ROUTES DE MODULO ADMINISTRATION---------------------------------------------------------------------------
//TRANSACTIONS
Route::get('transactions/{sign}', 'Web\TransactionController@index')->name('transactions.index');
Route::get('transactionsCreate/{sign}', 'Web\TransactionController@create')->name('transactions.create');
Route::post('transactions/store', 'Web\TransactionController@store')->name('transactions.store');
Route::get('transactions/{id}/edit', 'Web\TransactionController@edit')->name('transactions.edit');
Route::get('transactions/{sign}/{id}/show', 'Web\TransactionController@show')->name('transactions.show');
Route::delete('transactions/{sign}/{id}/delete', 'Web\TransactionController@delete')->name('transactions.delete');
//TYPES OF TRANSACTIONS
Route::resource('transactionsTypes', 'Web\TransactionTypeController', ['except' => ['create']]);
//BANK
Route::resource('banks', 'Web\BankController', ['except' => ['create']]);
//RECEIVABLE
Route::get('receivables', 'Web\ReceivableController@index')->name('receivables.index');
Route::post('receivables', 'Web\ReceivableController@index')->name('receivables.index');
Route::get('receivables/{clientId}', 'Web\ReceivableController@details')->name('receivables.details');

Route::get('receivables/printReceipt', 'Web\ReportController@printReceipt')->name('receivables.printReceipt');

//REPORTS
Route::get('transactions-summary', function () {return view('module_administration.reportincomeexpenses.index');})->name('transactions.incomeexpenses');
Route::post('transactions-summary', 'Web\ReportController@transactionsSummary')->name('reports.incomeexpenses');
Route::get('transactions-income', function () {return view('module_administration.reportincome.index');})->name('transactions.income');
Route::post('transactions-income', 'Web\ReportController@transactionSummaryForSign')->name('reports.income');
Route::get('transactionsexpenses', function () {return view('module_administration.reportexpenses.index');})->name('transactions.expenses');
Route::post('transactionsexpenses', 'Web\ReportController@transactionSummaryForSign')->name('reports.expenses');

Route::get('collection-report', 'Web\ReceivableController@reportCollections')->name('collections.index');
Route::post('collection-report', 'Web\ReportController@collections')->name('collections.result');
