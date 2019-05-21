<?php

use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Auth::routes();

Route::get('/', function () {
    return redirect()->route('login');
});
//ROUTE FROM FILES
Route::get('/uploads/{type}/{directoryName}/{file}', function ($type,$directoryName, $file) {
    return Storage::download("docs/$type/$directoryName/$file");
})->name('uploads');

Route::get('/filesDelete/{type}/{directoryName}/{file}', function ($type,$directoryName, $file) {
    Storage::delete("docs/$type/$directoryName/$file");
    return redirect()->back();
})->name('files.delete');

//SWICTH CAMBIO DE LOCALITATION (LANGUAGUE)
Route::get('/language/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
})->name('language')->middleware('web');

//ROUTE HOME
Route::get('/home', 'HomeController@index')->name('home');

//ROUTES DE MODULO CONTRACTS------------------------------------------------------------------
//PROJECTS********
Route::resource('projects', 'Web\ProjectTypeController', ['except' => ['create']]);
//SERVICES********
Route::resource('services', 'Web\ServiceTypeController', ['except' => ['create']]);
//CLIENTS************
Route::resource('clients', 'Web\ClientController');
//PRECONTRACTS**********
Route::resource('precontracts', 'Web\PrecontractController');
Route::get('precontractsCreate/{contractType}', 'Web\PrecontractController@create')->name('precontracts.create');
Route::get('precontracts/{precontract}/details', 'Web\PrecontractController@details')->name('precontracts.details');
//PRECONTRACTS- OPTIONS
Route::get('precontractsPayment/{id}', 'Web\PrecontractController@payment')->name('precontracts.payment');
Route::post('precontractsPayment/agg', 'Web\PrecontractController@paymentAgg')->name('precontracts.paymentAgg');
Route::get('precontractsPayment/{id}/{amount}/{precontractId}/remove', 'Web\PrecontractController@paymentRemove')->name('precontracts.paymentRemove');

Route::get('precontractsFile/{id}', 'Web\PrecontractController@files')->name('precontracts.files');
Route::post('precontractsFileAgg', 'Web\PrecontractController@fileAgg')->name('precontracts.fileAgg');

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
Route::post('contractsStaff/agg', 'Web\ContractController@staffAgg')->name('contracts.staffAgg');
Route::get('contractsStaff/{id}/{contracId}/remove', 'Web\ContractController@staffRemove')->name('contracts.staffRemove');

Route::get('contractsFile/{id}', 'Web\ContractController@files')->name('contracts.files');
Route::post('contractsFileAgg', 'Web\ContractController@fileAgg')->name('contracts.fileAgg');

Route::get('contractsPayment/{id}', 'Web\ContractController@payment')->name('contracts.payment');
Route::post('contractsPayment/agg', 'Web\ContractController@paymentAgg')->name('contracts.paymentAgg');
Route::get('contractsPayment/{id}/{amount}/{contractId}/remove', 'Web\ContractController@paymentRemove')->name('contracts.paymentRemove');
//CONTRACT-SEARCH********
Route::get('contractsGeneralSearch', 'Web\ContractController@generalSearch')->name('contracts.generalSearch');
Route::get('contractsGeneralSearch/{contract}/details', 'Web\ContractController@generalSearchDetails')->name('contracts.generalSearchDetails');
Route::get('contractsStatus', 'Web\ContractController@searchStatus')->name('contracts.searchStatus');
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
Route::get('contracts-print', function () {return view('contractprint.index');})->name('contracts.print');
Route::post('reportsContract', 'Web\ReportController@printContract')->name('reports.contract');
Route::get('contracts-summary', function () {return view('contractsummary.index');})->name('contracts.summary');
Route::post('contracts-summary', 'Web\ReportController@summaryContract')->name('reports.summaryContract');
Route::get('contracts-summary-for-clients', 'Web\ContractController@summaryForClient')->name('contracts.summaryForClient');
Route::post('contracts-summary-for-clients', 'Web\ReportController@summaryForClient')->name('reports.summaryForClient');

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
//REPORTS
Route::get('transactions-summary', function () {return view('reportincomeexpenses.index');})->name('transactions.incomeexpenses');
Route::post('transactions-summary', 'Web\ReportController@transactionsSummary')->name('reports.incomeexpenses');
Route::get('transactions-income', function () {return view('reportincome.index');})->name('transactions.income');
Route::post('transactions-income', 'Web\ReportController@transactionSummaryForSign')->name('reports.income');
Route::get('transactionsexpenses', function () {return view('reportexpenses.index');})->name('transactions.expenses');
Route::post('transactionsexpenses', 'Web\ReportController@transactionSummaryForSign')->name('reports.expenses');

Route::get('collection-report', 'Web\ReceivableController@reportCollections')->name('collections.index');
Route::post('collection-report', 'Web\ReportController@collections')->name('collections.result');

//ROUTES DE AXIOS ------------------------------------------------------------------------------------------
//COUNTRYS
Route::get('countrys/all', 'Web\CountryController@all')->name('countrys.all');
//OFFICES
Route::get('offices/{contract}', 'Web\OfficeController@getForCountry')->name('offices.get');
//CONTRACTS
Route::get('contracts-office/{officeId}', 'Web\ContractController@getForOffice')->name('contracts.getForOffice');
Route::get('searchClients/{client?}', 'Web\ClientController@get')->name('searchClients.get');
//ADMINISTRATION - RECEIVABLE
Route::get('receivables/get/{receivableId}', 'Web\ReceivableController@getForId')->name('receivables.getForId');
Route::post('receivables/share', 'Web\ReceivableController@share')->name('receivables.share');

//BANK
Route::get('banks/country/{countryId}', 'Web\BankController@getForCountry')->name('banks.getForCountry');
Route::get('banks/account/{bankId}', 'Web\BankController@getAccount')->name('banks.account');
