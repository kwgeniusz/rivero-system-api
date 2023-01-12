<?php

//--------------------ADMINISTRATION MODULE ROUTES-------------------------//

//**************************** PROPOSALS ***************************
// Route::get('proposalsAll', 'Web\ProposalController@getAllProposals')->name('proposals.all');
// Route::post('filteredProposals', 'Web\ProposalController@getAllProposals')->name('proposals.filtered');

//**************************** INVOICES ***************************
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

//**************************** SALE NOTES ***************************
Route::get('invoices/{id}/sale-notes', 'Web\InvoiceSaleNoteController@getAll')->name('invoiceSaleNotes.getAll');
Route::get('invoices/{id}/sale-notes/{noteType}/create', 'Web\InvoiceSaleNoteController@create')->name('invoiceSaleNotes.create');
Route::post('invoices/sale-notes/store', 'Web\InvoiceSaleNoteController@store')->name('invoiceSaleNotes.store');

 // SUB-CATEGORIES
Route::get('invoicesCancelled', 'Web\InvoiceController@InvoicesCancelled')->name('invoices.cancelled');
Route::get('invoicesAll', 'Web\InvoiceController@getAllInvoices')->name('invoices.all');
Route::post('filteredInvoices', 'Web\InvoiceController@getAllInvoices')->name('invoices.filtered');
// Route::put('invoicesCollections', 'Web\InvoiceController@invoicesCollections')->name('invoices.close');

//**************************** TRANSACTIONS ***************************
Route::get('transactions/{sign}/index', 'Web\TransactionController@index')->name('transactions.index');
Route::post('transactions', 'Web\TransactionController@store')->name('transactions.store');
Route::get('transactions/{id}', 'Web\TransactionController@show')->name('transactions.show');
Route::put('transactions/{id}', 'Web\TransactionController@update')->name('transactions.update');
Route::delete('transactions/{id}', 'Web\TransactionController@delete')->name('transactions.delete');
Route::post('transactions/{sign}/search-between-dates', 'Web\TransactionController@searchBetweenDates')->name('transactions.searchBetweenDates');
Route::post('transactions/{sign}/search-by-year', 'Web\TransactionController@searchByYear')->name('transactions.searchByYear');

//**************************** CASHBOX ***************************
Route::resource('cashboxs', 'Web\CashboxController');
Route::get('cashboxTransactions', 'Web\CashboxController@transactions')->name('cashbox.transactions');
Route::post('cashboxTransactionsResults', 'Web\CashboxController@transactions')->name('cashbox.transactionsResults');

//**************************** BANK ***************************
Route::resource('banks', 'Web\BankController');
Route::get('banksTransactions', 'Web\BankController@transactions')->name('banks.transactions');
Route::post('banksTransactionsResults', 'Web\BankController@transactions')->name('banks.transactionsResults');
Route::get('banksByOffice', 'Web\BankController@getAllByOffice');///axios

//**************************** ACCOUNTS ***************************
Route::get('accounts/{bankId}', 'Web\AccountController@index');

//**************************** TYPES OF TRANSACTIONS ***************************
// Route::resource('transactionsTypes', 'Web\TransactionTypeController', ['parameters' => ['transaction-types' => 'id']] );
Route::get('transaction-types/{sign}/index', 'Web\TransactionTypeController@index')->name('transactionTypes.index');
Route::post('transaction-types', 'Web\TransactionTypeController@store')->name('transactionTypes.store');
Route::get('transaction-types/{id}', 'Web\TransactionTypeController@show')->name('transactionTypes.show');
Route::put('transactions-types/{id}', 'Web\TransactionTypeController@update')->name('transactionTypes.update');
Route::delete('transaction-types/{id}', 'Web\TransactionTypeController@delete')->name('transactionTypes.delete');


//****************************** SUBCONTRACTORS ***********************************
Route::resource('subcontractors', 'Web\SubcontractorController', ['parameters' => ['subcontractors' => 'id']]);
Route::get('subcontractors/{subcontName}/search', 'Web\SubcontractorController@getFiltered')->name('subcontractors.search');

 //->Subcontractor Payables
Route::get('subcontractors/{id}/payables', 'Web\SubcontractorPayableController@index')->name('subcontractors.payables');

 //->Subcontractor relationed with invoice
Route::get('subcontractors/list/{invDetailId}/invDetail', 'Web\SubcontractorPayableController@listSubcontInvDetail');
Route::post('subcontractors/add/invDetail', 'Web\SubcontractorPayableController@addSubcontInvDetail');
Route::post('subcontractors/remove/invDetail', 'Web\SubcontractorPayableController@removeSubcontInvDetail');

//**************************** PAYABLES ******************************
Route::get('payables', 'Web\PayableController@index')->name('payables.index');
Route::post('payables/pay', 'Web\PayableController@pay')->name('payables.pay');

//**************************** RECEIVABLES ***************************
Route::get('receivables', 'Web\ReceivableController@index')->name('receivables.index');
Route::get('receivables/{clientId}', 'Web\ReceivableController@details')->name('receivables.details');

Route::get('receivables-paymentMethod', 'Web\ReceivableController@paymentMethod')->name('receivables.paymentMethod');
Route::get('receivables/get/{receivableId}', 'Web\ReceivableController@getForId')->name('receivables.getForId');

Route::post('receivables/share', 'Web\ReceivableController@share')->name('receivables.share');
Route::post('receivablesConfirmPayment', 'Web\ReceivableController@confirmPayment')->name('receivables.confirmPayment');

//**************************** COST CATEGORIES ******************************
Route::get('cost-categories', 'Web\CostCategoryController@index')->name('costCategories.index');
Route::get('cost-categories/{id}/subcategories', 'Web\CostCategoryController@subcategories')->name('costCategories.subcategories');

//**************************** REPORTS **************************************
Route::get('reportsProposal', 'Report\Pdf\AdministrationControllerPDF@printProposal')->name('reports.proposal');
Route::get('reportsInvoice', 'Report\Pdf\AdministrationControllerPDF@printInvoice')->name('reports.invoice');

Route::get('reports/credit-note', 'Report\Pdf\AdministrationControllerPDF@printCreditNote')->name('reports.credit-note');
Route::get('reports/debit-note', 'Report\Pdf\AdministrationControllerPDF@printDebitNote')->name('reports.debit-note');

Route::post('reports/expenses', 'Report\Pdf\AdministrationControllerPDF@printExpenses')->name('reports.expenses');
Route::post('reports/incomes',  'Report\Pdf\AdministrationControllerPDF@printIncomes')->name('reports.incomes');

Route::get('reports/total-contracts', 'Report\Pdf\AdministrationControllerPDF@printTotalContracts')->name('reports.administration.totalContracts');

Route::get('reportsStatement', 'Report\Pdf\AdministrationControllerPDF@printStatement')->name('reports.statement');
Route::get('reportsReceipt', 'Report\Pdf\AdministrationControllerPDF@printReceipt')->name('reports.printReceipt');
Route::get('reportsPaymentRequest', 'Report\Pdf\AdministrationControllerPDF@printPaymentRequest')->name('reports.paymentRequest');
Route::get('reportsReceivables', 'Report\Pdf\AdministrationControllerPDF@printReceivables')->name('reports.receivables');

//***************************************************************************
//***************** TEMPORARY ACCOUNTING ENTRY ******************************
//***************************************************************************
Route::prefix('accounting')->group(function () {

   Route::get('temporary-accounting-entries', 'Web\Administration\TemporaryAccEntryController@index')->name('temporary-acc-entry.index');
   
});
