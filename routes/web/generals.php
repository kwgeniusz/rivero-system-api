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


