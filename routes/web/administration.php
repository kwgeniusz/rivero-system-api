<?php

//ROUTES DE MODULO ADMINISTRATION---------------------------------------------------------------------------
//TRANSACTIONS INCOME AND EXPENSES
Route::get('transactions/{sign}', 'Web\TransactionController@index')->name('transactions.index');
Route::post('transactions/{sign}/filtered', 'Web\TransactionController@index')->name('transactions.filtered');
Route::get('transactionsCreate/{sign}', 'Web\TransactionController@create')->name('transactions.create');
Route::post('transactions/store', 'Web\TransactionController@store')->name('transactions.store');
Route::get('transactions/{id}/edit', 'Web\TransactionController@edit')->name('transactions.edit');
Route::get('transactions/{sign}/{id}/show', 'Web\TransactionController@show')->name('transactions.show');
Route::delete('transactions/{sign}/{id}/delete', 'Web\TransactionController@delete')->name('transactions.delete');

//INVOICES
Route::get('invoicesAll', 'Web\InvoiceController@getAllInvoices')->name('invoices.all');
Route::post('filteredInvoices', 'Web\InvoiceController@getAllInvoices')->name('invoices.filtered');
//PROPOSALS
Route::get('proposalsAll', 'Web\ProposalController@getAllProposals')->name('proposals.all');
Route::post('filteredProposals', 'Web\ProposalController@getAllProposals')->name('proposals.filtered');
//CASHBOX
Route::resource('cashboxs', 'Web\CashboxController');
Route::get('cashboxTransactions', 'Web\CashboxController@transactions')->name('cashbox.transactions');
Route::post('cashboxTransactionsResults', 'Web\CashboxController@transactions')->name('cashbox.transactionsResults');
//BANK
Route::resource('banks', 'Web\BankController');
Route::get('banksTransactions', 'Web\BankController@transactions')->name('banks.transactions');
Route::post('banksTransactionsResults', 'Web\BankController@transactions')->name('banks.transactionsResults');

Route::get('banksByOffice', 'Web\BankController@getAllByOffice');///axios
//ACCOUNTS
Route::get('accounts/{bankId}', 'Web\AccountController@index');



//TYPES OF TRANSACTIONS
// Route::resource('transactionsTypes', 'Web\TransactionTypeController', ['except' => ['create']]);

//RECEIVABLE
Route::get('receivables', 'Web\ReceivableController@index')->name('receivables.index');
Route::get('receivables/{clientId}', 'Web\ReceivableController@details')->name('receivables.details');
Route::get('receivables-paymentMethod', 'Web\ReceivableController@paymentMethod')->name('receivables.paymentMethod');
Route::get('receivablesPrintReceipt/', 'Web\ReportController@printReceipt')->name('receivables.printReceipt');
Route::get('receivables/get/{receivableId}', 'Web\ReceivableController@getForId')->name('receivables.getForId');
Route::post('receivables/share', 'Web\ReceivableController@share')->name('receivables.share');
Route::post('receivablesConfirmPayment', 'Web\ReceivableController@confirmPayment')->name('receivables.confirmPayment');
//REPORTS
Route::get('transactions-summary', function () {return view('module_administration.reportincomeexpenses.index');})->name('transactions.incomeexpenses');
Route::post('transactions-summary', 'Web\ReportController@transactionsSummary')->name('reports.incomeexpenses');
Route::get('transactions-income', function () {return view('module_administration.reportincome.index');})->name('transactions.income');
Route::post('transactions-income', 'Web\ReportController@transactionSummaryForSign')->name('reports.income');
Route::get('transactionsexpenses', function () {return view('module_administration.reportexpenses.index');})->name('transactions.expenses');
Route::post('transactionsexpenses', 'Web\ReportController@transactionSummaryForSign')->name('reports.expenses');
Route::get('collection-report', 'Web\ReceivableController@reportCollections')->name('collections.index');
Route::post('collection-report', 'Web\ReportController@collections')->name('collections.result');
