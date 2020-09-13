<?php

//ROUTES DE MODULO ADMINISTRATION---------------------------------------------------------------------------
//PROPOSALS
Route::get('proposalsAll', 'Web\ProposalController@getAllProposals')->name('proposals.all');
Route::post('filteredProposals', 'Web\ProposalController@getAllProposals')->name('proposals.filtered');

//INVOICES
Route::resource('invoices', 'Web\InvoiceController');
Route::resource('invoicesNotes', 'Web\InvoiceNoteController');
Route::resource('invoicesScopes', 'Web\InvoiceScopeController');
Route::resource('invoicesDetails', 'Web\InvoiceDetailController');
Route::get('invoicesDetails/{invoiceId}/withPrice', 'Web\InvoiceDetailController@getWithPriceByInvoice')->name('invoicesDetails.withPrice');
Route::get('invoicesPayments/{id}', 'Web\InvoiceController@payments')->name('invoices.payments');
Route::post('invoicesPayments/add', 'Web\InvoiceController@paymentsAdd')->name('invoices.paymentsAdd');
Route::get('invoicesPayments/{id}/{invoiceId}/remove', 'Web\InvoiceController@paymentsRemove')->name('invoices.paymentsRemove');
Route::get('invoices/{id}/subcontractors', 'Web\InvoiceController@subcontractors')->name('invoices.subcontractors');
Route::put('invoices/{invoiceId}/changeStatus','Web\InvoiceController@changeStatus')->name('invoices.changeStatus');

 // sub categories 
Route::get('invoicesCancelled', 'Web\InvoiceController@InvoicesCancelled')->name('invoices.cancelled');
Route::get('invoicesAll', 'Web\InvoiceController@getAllInvoices')->name('invoices.all');
Route::post('filteredInvoices', 'Web\InvoiceController@getAllInvoices')->name('invoices.filtered');
// Route::put('invoicesCollections', 'Web\InvoiceController@invoicesCollections')->name('invoices.close');

//TRANSACTIONS INCOME AND EXPENSES
Route::get('transactions/{sign}', 'Web\TransactionController@index')->name('transactions.index');
Route::post('transactions/{sign}/filtered', 'Web\TransactionController@index')->name('transactions.filtered');
Route::get('transactionsCreate/{sign}', 'Web\TransactionController@create')->name('transactions.create');
Route::post('transactions/store', 'Web\TransactionController@store')->name('transactions.store');
Route::get('transactions/{id}/edit', 'Web\TransactionController@edit')->name('transactions.edit');
Route::get('transactions/{sign}/{id}/show', 'Web\TransactionController@show')->name('transactions.show');
Route::delete('transactions/{sign}/{id}/delete', 'Web\TransactionController@delete')->name('transactions.delete');

//SALE NOTES
Route::resource('saleNotes', 'Web\SaleNoteController');
Route::get('saleNotes/invoice/{invoiceId}', 'Web\SaleNoteController@getByInvoice')->name('saleNotes.getByInvoice');

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
Route::get('receivables/get/{receivableId}', 'Web\ReceivableController@getForId')->name('receivables.getForId');
Route::post('receivables/share', 'Web\ReceivableController@share')->name('receivables.share');
Route::post('receivablesConfirmPayment', 'Web\ReceivableController@confirmPayment')->name('receivables.confirmPayment');
