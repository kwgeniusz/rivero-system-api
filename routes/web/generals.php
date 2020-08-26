<?php

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
//CHANGE OF LOCALIZATION
Route::get('/localization/{language}', function ($language) {
    Session::put('language', $language);
    return redirect()->back();
})->name('localization')->middleware('web');

//HOME ROUTE----------------------------------------------------------------------------
Route::get('/home', 'HomeController@index')->name('home');

//---------------------AXIOS ROUTES ----------------------------------------------------//

//CONTRACTS********************************************
//COUNTRYS
Route::get('countrys/all', 'Web\CountryController@all')->name('countrys.all');
//CLIENT
Route::get('clientNumberFormat/get', 'Web\ClientController@getNumberFormat')->name('clients.getNumberFormat');
//CONTACT TYPE
// Route::get('contactTypes/all', 'Web\ContactTypeController@all')->name('contactTypes.all');
//COMPANY
Route::get('companies/{countryId}', 'Web\CompanyController@getForCountry')->name('companies.get');
//CONTRACTS
Route::get('contracts-office/{officeId}', 'Web\ContractController@getForOffice')->name('contracts.getForOffice');
Route::get('searchClients/{client?}', 'Web\ClientController@get')->name('searchClients.get');
Route::get('precontract-allFiles/{id}/{type}', 'Web\PrecontractController@getFiles')->name('precontract.getFiles');

//ROUTES TO STATISTIC **********************
Route::get('statistic/clients', 'Web\StatisticController@numberOfClients')->name('statistic.clients');

Route::get('statistic/contracts', 'Web\StatisticController@numberOfContracts')->name('statistic.contracts');
Route::get('statistic/contractsFinished', 'Web\StatisticController@numberOfContractsFinished')->name('statistic.contractsFinished');
Route::get('statistic/contractsCancelled', 'Web\StatisticController@numberOfContractsCancelled')->name('statistic.contractsCancelled');
Route::get('statistic/contractsCommercial', 'Web\StatisticController@numberOfContractsCommercial')->name('statistic.contractsCommercial');
Route::get('statistic/contractsResidencial', 'Web\StatisticController@numberOfContractsResidencial')->name('statistic.contractsResidencial');

Route::get('statistic/invoicesOpen', 'Web\StatisticController@numberOfInvoiceOpen')->name('statistic.contractsResidencial');
Route::get('statistic/invoicesClosed', 'Web\StatisticController@numberOfInvoiceClosed')->name('statistic.invoicesResidencial');
Route::get('statistic/invoicesPaid', 'Web\StatisticController@numberOfInvoicePaid')->name('statistic.invoicesResidencial');
Route::get('statistic/invoicesCancelled', 'Web\StatisticController@numberOfInvoiceCancelled')->name('statistic.invoicesResidencial');

//***************************************ROUTES TO REPORTS**********************//
//-----------------------------CONTRACTS---------------------------------------------------//
// Route::get('contracts-print', function () {return view('contractprint.index');})->name('contracts.print');
Route::get('reportsContract', 'Web\ReportController@printContract')->name('reports.contract');
// Route::get('contracts-summary', function () {return view('contractsummary.index');})->name('contracts.summary');
Route::get('contracts-summary', 'Web\ReportController@summaryContractForCompany')->name('reports.summaryContractForCompany');
Route::get('contracts-summary-for-clients', 'Web\ReportController@summaryClientForm')->name('contracts.summaryForClient');
Route::post('contracts-summary-for-clients', 'Web\ReportController@summaryForClient')->name('reports.summaryForClient');

Route::get('reportsProposal', 'Report\Pdf\AdministrationControllerPDF@printProposal')->name('reports.proposal');
Route::get('reportsInvoice', 'Report\Pdf\AdministrationControllerPDF@printInvoice')->name('reports.invoice');
Route::get('reportsStatement', 'Report\Pdf\AdministrationControllerPDF@printStatement')->name('reports.statement');
Route::get('reportsReceipt', 'Report\Pdf\AdministrationControllerPDF@printReceipt')->name('reports.printReceipt');

//-----------------------------ADMINISTRATION--------------------------------------------------//
// Route::get('transactions-summary', function () {return view('module_administration.reportincomeexpenses.index');})->name('transactions.incomeexpenses');
// Route::post('transactions-summary', 'Web\ReportController@transactionsSummary')->name('reports.incomeexpenses');
// Route::get('transactions-income', function () {return view('module_administration.reportincome.index');})->name('transactions.income');
// Route::post('transactions-income', 'Web\ReportController@transactionSummaryForSign')->name('reports.income');
// Route::get('transactionsexpenses', function () {return view('module_administration.reportexpenses.index');})->name('transactions.expenses');
// Route::post('transactionsexpenses', 'Web\ReportController@transactionSummaryForSign')->name('reports.expenses');
// Route::get('collection-report', 'Web\ReceivableController@reportCollections')->name('collections.index');
// Route::post('collection-report', 'Web\ReportController@collections')->name('collections.result');


