<?php

//--------------------CONTRACT MODULE ROUTES-------------------------//
//****************************CLIENTS***************************//
Route::resource('clients', 'Web\ClientController');
Route::resource('contactTypes', 'Web\ContactTypeController');
//CLIENTS-OTHER CONTACTS
 Route::get('clients/{id}/other-contacts', 'Web\ClientOtherContactController@index')->name('clientsOtherContact.index');
 Route::post('clients/{id}/other-contacts', 'Web\ClientOtherContactController@store')->name('clientsOtherContact.store');
 Route::get('other-contacts/{id}', 'Web\ClientOtherContactController@show')->name('clientsOtherContact.show');
 Route::put('other-contacts/{id}', 'Web\ClientOtherContactController@update')->name('clientsOtherContact.update');
 Route::delete('other-contacts/{id}', 'Web\ClientOtherContactController@destroy')->name('clientsOtherContact.destroy');


//**************************PRECONTRACTS*************************//
Route::resource('precontracts', 'Web\PrecontractController', ['parameters' => ['precontracts' => 'id']]);
Route::put('precontracts/{id}/update-ibc', 'Web\PrecontractController@updateIbc')->name('precontracts.updateIbc');
Route::get('precontracts/{id}/details', 'Web\PrecontractController@details')->name('precontracts.details');

Route::get('converted-precontracts',   'Web\PrecontractController@convertedPrecontractsIndex')->name('convertedPrecontract.index');
Route::get('unconverted-precontracts', 'Web\PrecontractController@unconvertedPrecontractsIndex')->name('unconvertedPrecontract.index');

//PRECONTRACTS-OPTIONS
 // ->Precontract Files
Route::get('precontracts/{id}/files', 'Web\PrecontractFileController@index')->name('precontractsFile.index');
Route::post('precontracts/{id}/files', 'Web\PrecontractFileController@store')->name('precontractsFile.store');
 // ->Convert Precontract to Contract
Route::get('precontractsConvert/{id}', 'Web\PrecontractController@convert')->name('precontracts.convert');
Route::post('precontractsConvert/add/{id}', 'Web\PrecontractController@convertAdd')->name('precontracts.convertAdd');
 // ->Precontract Comments
Route::get('precontracts/{id}/comments', 'Web\PrecontractCommentController@index')->name('precontractsComment.index');
Route::post('precontracts/{id}/comments', 'Web\PrecontractCommentController@store')->name('precontractsComment.store');

//***************************PROPOSAL***************************
Route::resource('proposals', 'Web\ProposalController');
Route::resource('proposalsDetails', 'Web\ProposalDetailController');

 //->Proposal Scopes
Route::get('proposals/{id}/scopes', 'Web\ProposalScopeController@index')->name('proposalsScopes.index');
Route::post('proposals/{id}/scopes', 'Web\ProposalScopeController@store')->name('proposalsScopes.store');

 //->Proposal Time Frames
Route::get('proposals/{id}/time-frames', 'Web\ProposalTimeFrameController@index')->name('proposalsTimeFrames.index');
Route::post('proposals/{id}/time-frames', 'Web\ProposalTimeFrameController@store')->name('proposalsTimeFrames.store');
// Route::resource('time-frames', 'Web\TimeFrameController', ['parameters' => ['time-frames' => 'id']]);

 //->Proposal Terms and Conditions
Route::get('proposals/{id}/terms', 'Web\ProposalTermController@index')->name('proposalsTerms.index');
Route::post('proposals/{id}/terms', 'Web\ProposalTermController@store')->name('proposalsTerms.store');
// Route::resource('terms', 'Web\TermController', ['parameters' => ['terms' => 'id']]);

 //->Proposal Notes
Route::get('proposals/{id}/notes', 'Web\ProposalNoteController@index')->name('proposalsNotes.index');
Route::post('proposals/{id}/notes', 'Web\ProposalNoteController@store')->name('proposalsNotes.store');

 // ->Proposal Subcontractor
Route::put('proposal/{id}/update-subcontractor', 'Web\ProposalController@updateSubcontractor');

 // ->Proposal Payments
Route::get('proposalsPayments/{id}', 'Web\ProposalController@payments')->name('proposals.payments');
Route::post('proposalsPayments/add', 'Web\ProposalController@paymentsAdd')->name('proposals.paymentsAdd');
Route::get('proposalsPayments/{id}/{invoiceId}/remove', 'Web\ProposalController@paymentsRemove')->name('proposals.paymentsRemove');
 
// ->Proposal Convert
Route::get('proposals/{id}/convert', 'Web\ProposalController@convert')->name('proposals.convert');
Route::post('proposals/convert', 'Web\ProposalController@executeConvert')->name('proposals.executeConvert');

// ->Proposal Duplicate
Route::get('proposals/{id}/duplicate', function ($id) { return view('module_administration.proposals.duplicate', compact('id')); })->name('proposal.duplicate');
Route::post('proposals/duplicate', 'Web\ProposalController@duplicateProposal')->name('proposals.duplicate');

// ->Time Frames
Route::resource('timeframes', 'Web\TimeFrameController');
// ->Notes
Route::resource('notes', 'Web\NoteController');
// ->Terms & Conditions
Route::resource('terms', 'Web\TermController');
// -> Time Payments
Route::resource('timepayments', 'Web\TimePaymentController');
//*******************************CONTRACT**************************************//
Route::resource('contracts', 'Web\ContractController', ['except' => ['create']]);
Route::put('contracts/{id}/update-ibc', 'Web\ContractController@updateIbc')->name('contracts.updateIbc');
Route::get('contracts/{contract}/details', 'Web\ContractController@details')->name('contracts.details');
//CONTRACT-OPTIONS
 // ->Contract Change Status
Route::get('contractsChangeStatus/{contract}', 'Web\ContractController@changeStatus')->name('contracts.changeStatus');
Route::put('contractsupdateStatus', 'Web\ContractController@updateStatus')->name('contracts.updateStatus');
 // ->Contract staff
Route::get('contractsStaff/{contract}', 'Web\ContractController@staff')->name('contracts.staff');
Route::post('contractsStaff/add', 'Web\ContractController@staffAdd')->name('contracts.staffAdd');
Route::get('contractsStaff/{contractId}/remove/{staffId}', 'Web\ContractController@staffRemove')->name('contracts.staffRemove');
 // ->Contract File
Route::get('contractsFile/{id}', 'Web\ContractController@files')->name('contracts.files');
Route::get('contract/{id}/files/{type}', 'Web\ContractController@getFiles')->name('contracts.getFiles');
Route::post('contractsFileAdd', 'Web\ContractController@fileAdd')->name('contracts.fileAdd');
 // ->Contract Comments
Route::get('contracts/{id}/comments', 'Web\ContractCommentController@index')->name('contractsComment.index');
Route::post('contracts/{id}/comments', 'Web\ContractCommentController@store')->name('contractsComment.store');

//****************************FILES********************************
Route::get('files/{id}/download', 'Web\FileController@download')->name('files.download');
Route::post('files/download-zip', 'Web\FileController@downloadZip')->name('files.downloadZip');
Route::put('files/delete-multiple', 'Web\FileController@deleteMultiple')->name('files.deleteMultiple');
Route::put('files/move', 'Web\FileController@move')->name('files.move');

// //****************************COMMENTS********************************
// Route::resource('comments', 'Web\CommentController');
// Route::get('contracts/{modelId}/comments', 'Web\CommentController@getAllByModel')->name('contracts.comments');


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

