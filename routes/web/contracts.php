<?php

//-----------------------------------------CONTRACT MODULE ROUTES-------------------------------------------------------
//****************************CLIENTS***************************
Route::resource('clients', 'Web\ClientController');

//*************************SUBCONTRACTORS************************
Route::resource('subcontractors', 'Web\SubcontractorController');
Route::get('subcontractors/{subcontId}/payables', 'Web\SubcontractorController@payables')->name('subcontractors.payables');
Route::get('subcontractors/{subcontId}/getPayables', 'Web\SubcontractorController@getallPayables')->name('subcontractors.getallPayables');

//**************************PRECONTRACTS*************************
Route::resource('precontracts', 'Web\PrecontractController', ['parameters' => ['precontracts' => 'id']]);
Route::get('precontracts/{id}/details', 'Web\PrecontractController@details')->name('precontracts.details');
//PRECONTRACTS-OPTIONS
 // ->Precontract Files
Route::get('precontracts/{id}/files', 'Web\PrecontractFileController@index')->name('precontractsFile.index');
Route::post('precontracts/{id}/files', 'Web\PrecontractFileController@store')->name('precontractsFile.store');

 // ->Precontract Convert to Contract
Route::get('precontractsConvert/{id}', 'Web\PrecontractController@convert')->name('precontracts.convert');
Route::post('precontractsConvert/add/{id}', 'Web\PrecontractController@convertAdd')->name('precontracts.convertAgg');

//***************************PROPOSAL***************************
Route::resource('proposals', 'Web\ProposalController');
Route::resource('proposalsDetails', 'Web\ProposalDetailController');
Route::resource('proposalsNotes', 'Web\ProposalNoteController');
Route::resource('proposalsScopes', 'Web\ProposalScopeController');
 // ->Proposal Payments
Route::get('proposalsPayments/{id}', 'Web\ProposalController@payments')->name('proposals.payments');
Route::post('proposalsPayments/add', 'Web\ProposalController@paymentsAdd')->name('proposals.paymentsAdd');
Route::get('proposalsPayments/{id}/{invoiceId}/remove', 'Web\ProposalController@paymentsRemove')->name('proposals.paymentsRemove');
 // ->Proposal Proposal
Route::get('proposalsConvert', 'Web\ProposalController@convert')->name('proposals.convert');
Route::post('proposalsConvert/add/{id}', 'Web\ProposalController@convertAdd')->name('proposals.convertAdd');

//****************************CONTRACT*****************************
Route::resource('contracts', 'Web\ContractController', ['except' => ['create']]);
Route::get('contracts/{contract}/details', 'Web\ContractController@details')->name('contracts.details');
//CONTRACT-OPTIONS
 // ->Contract Change Status
Route::get('contractsChangeStatus/{contract}', 'Web\ContractController@changeStatus')->name('contracts.changeStatus');
Route::put('contractsupdateStatus', 'Web\ContractController@updateStatus')->name('contracts.updateStatus');
 // ->Contract staff
Route::get('contractsStaff/{contract}', 'Web\ContractController@staff')->name('contracts.staff');
Route::post('contractsStaff/add', 'Web\ContractController@staffAdd')->name('contracts.staffAdd');
Route::get('contractsStaff/{contractId}/remove/{staffId}', 'Web\ContractController@staffRemove')->name('contracts.staffRemove');
 // ->Proposal File
Route::get('contractsFile/{id}', 'Web\ContractController@files')->name('contracts.files');
Route::get('contract/{id}/files/{type}', 'Web\ContractController@getFiles')->name('contracts.getFiles');
Route::post('contractsFileAdd', 'Web\ContractController@fileAdd')->name('contracts.fileAdd');

//****************************FILES********************************
Route::get('fileDownloadByUnit/{docId}', 'Web\ContractController@fileDownloadByUnit')->name('contracts.fileDownloadByUnit');
Route::post('fileDownload', 'Web\ContractController@fileDownload')->name('contracts.fileDownload');
Route::put('fileDelete', 'Web\ContractController@fileDelete')->name('contracts.fileDelete');

//****************************COMMENTS********************************
Route::resource('comments', 'Web\CommentController');
Route::get('contracts/{modelId}/comments', 'Web\CommentController@getAllByModel')->name('contracts.comments');
//****************************+INVOICES********************************


//SUBCONTRACTORS*********
Route::resource('subcontractors', 'Web\SubcontractorController');
Route::get('subcontractors/list/{invDetailId}/invDetail', 'Web\SubcontractorController@listSubcontInvDetail');
Route::post('subcontractors/add/invDetail', 'Web\SubcontractorController@addSubcontInvDetail');
Route::post('subcontractors/remove/invDetail', 'Web\SubcontractorController@removeSubcontInvDetail');
Route::get('searchSubcontractor/{subcontName}', 'Web\SubcontractorController@getFiltered')->name('searchSubcontractor.getFiltered');
//CONTRACT-SEARCH********
Route::get('contractsGeneralSearch', 'Web\ContractController@generalSearch')->name('contracts.generalSearch');
Route::get('contractsGeneralSearch/{contract}/details', 'Web\ContractController@generalSearchDetails')->name('contracts.generalSearchDetails');
Route::get('contractsStatus', function () {return view('module_contracts.contractstatus.index');})->name('contracts.searchStatus');
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

