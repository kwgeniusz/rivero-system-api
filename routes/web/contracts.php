<?php


//CONTRACT MODULE ROUTES------------------------------------------------------------------
//CLIENTS************
Route::resource('clients', 'Web\ClientController');
//PRECONTRACTS**********
Route::resource('precontracts', 'Web\PrecontractController');
Route::get('precontractsCreate/{contractType}', 'Web\PrecontractController@create')->name('precontracts.create');
Route::get('precontracts/{precontract}/details', 'Web\PrecontractController@details')->name('precontracts.details');
//PRECONTRACTS-OPTIONS
Route::get('precontractsPayment/{id}', 'Web\PrecontractController@payment')->name('precontracts.payment');
Route::post('precontractsPayment/agg', 'Web\PrecontractController@paymentAgg')->name('precontracts.paymentAgg');
Route::get('precontractsPayment/{id}/{amount}/{precontractId}/remove', 'Web\PrecontractController@paymentRemove')->name('precontracts.paymentRemove');
Route::get('precontractsFile/{id}', 'Web\PrecontractController@files')->name('precontracts.files');
Route::post('precontractsFileAgg', 'Web\PrecontractController@fileAgg')->name('precontracts.fileAgg');
Route::get('/precontract-download/{typeContract}/{directoryName}/{file}', 'Web\PrecontractController@fileDownload')->name('precontracts.fileDownload');
Route::get('/precontract-fileDelete/{typeContract}/{directoryName}/{file}', 'Web\PrecontractController@fileDelete')->name('precontracts.fileDelete');
Route::get('precontractsConvert/{id}', 'Web\PrecontractController@convert')->name('precontracts.convert');
Route::post('precontractsConvert/Agg/{id}', 'Web\PrecontractController@convertAgg')->name('precontracts.convertAgg');

//CONTRACT*********
Route::resource('contracts', 'Web\ContractController');
Route::get('contractsCreate/{contractType}', 'Web\ContractController@create')->name('contracts.create');
Route::get('contracts/{contract}/details', 'Web\ContractController@details')->name('contracts.details');
//CONTRACT-OPTIONS
Route::get('contractsChangeStatus/{contract}/', 'Web\ContractController@changeStatus')->name('contracts.changeStatus');
Route::put('contractsupdateStatus', 'Web\ContractController@updateStatus')->name('contracts.updateStatus');

Route::get('contractsStaff/{contract}/', 'Web\ContractController@staff')->name('contracts.staff');
Route::post('contractsStaff/add', 'Web\ContractController@staffAdd')->name('contracts.staffAdd');
Route::get('contractsStaff/{contractId}/remove/{staffId}', 'Web\ContractController@staffRemove')->name('contracts.staffRemove');

Route::get('contractsFile/{id}', 'Web\ContractController@files')->name('contracts.files');
Route::post('contractsFileAgg', 'Web\ContractController@fileAgg')->name('contracts.fileAgg');
Route::get('download/{docId}', 'Web\ContractController@fileDownload')->name('contracts.fileDownload');
Route::get('fileDelete/{docId}', 'Web\ContractController@fileDelete')->name('contracts.fileDelete');
//INVOICES*********
Route::resource('invoices', 'Web\InvoiceController');
Route::put('invoicesClose', 'Web\InvoiceController@closeInvoice')->name('invoices.close');
Route::get('invoicesPayments/{id}', 'Web\InvoiceController@payments')->name('invoices.payments');
Route::post('invoicesPayments/add', 'Web\InvoiceController@paymentsAdd')->name('invoices.paymentsAdd');
Route::get('invoicesPayments/{id}/{invoiceId}/remove', 'Web\InvoiceController@paymentsRemove')->name('invoices.paymentsRemove');

Route::get('invoicesNotes', 'Web\InvoiceController@notes')->name('invoices.notes');
Route::post('invoicesNotes/add', 'Web\InvoiceController@notesAdd')->name('invoices.notesAdd');
Route::delete('invoicesNotes/{invoiceId}/remove/{noteId}', 'Web\InvoiceController@notesRemove')->name('invoices.notesRemove');
Route::resource('invoicesDetails', 'Web\InvoiceDetailController');

Route::resource('services', 'Web\ServiceController');
Route::resource('notes', 'Web\NoteController');
Route::get('reportsInvoice', 'Web\ReportController@printInvoice')->name('reports.invoice');

//CONTRACT-SEARCH********
Route::get('contractsGeneralSearch', 'Web\ContractController@generalSearch')->name('contracts.generalSearch');
Route::get('contractsGeneralSearch/{contract}/details', 'Web\ContractController@generalSearchDetails')->name('contracts.generalSearchDetails');
Route::get('contractsStatus', function () {return view('contractstatus.index');})->name('contracts.searchStatus');
Route::post('contractsStatus/result', 'Web\ContractController@resultStatus')->name('contracts.resultStatus');
Route::get('contractsStatus/{contract}/', 'Web\ContractController@resultStatusDetails')->name('contracts.resultStatusDetails');
//CONTRACT-FINISHED*******
Route::get('contractsFinished', 'Web\ContractController@getContractsFinished')->name('contracts.finished');
Route::get('contractsFinished/{id}/details', 'Web\ContractController@detailsContractsFinished')->name('contracts.finishedDetails');
Route::get('contractsFinished/{id}/show', 'Web\ContractController@showContractsFinished')->name('contracts.finishedShow');
Route::delete('contractsFinished/{id}/delete', 'Web\ContractController@deleteContractsFinished')->name('contracts.finishedDelete');
//CONTRACT-CANCELLED*********
Route::get('contractsCancelled', 'Web\ContractController@getContractsCancelled')->name('contracts.cancelled');
Route::get('contractsCancelled/{id}/details', 'Web\ContractController@detailsContractsCancelled')->name('contracts.cancelledDetails');
Route::get('contractsCancelled/{id}/show', 'Web\ContractController@showContractsCancelled')->name('contracts.cancelledShow');
Route::delete('contractsCancelled/{id}/delete', 'Web\ContractController@deleteContractsCancelled')->name('contracts.cancelledDelete');

//REPORTS
// Route::get('contracts-print', function () {return view('contractprint.index');})->name('contracts.print');
Route::get('reportsContract', 'Web\ReportController@printContract')->name('reports.contract');
// Route::get('contracts-summary', function () {return view('contractsummary.index');})->name('contracts.summary');
Route::get('contracts-summary', 'Web\ReportController@summaryContractForOffice')->name('reports.summaryContractForOffice');
Route::get('contracts-summary-for-clients', 'Web\ReportController@summaryClientForm')->name('contracts.summaryForClient');
Route::post('contracts-summary-for-clients', 'Web\ReportController@summaryForClient')->name('reports.summaryForClient');
