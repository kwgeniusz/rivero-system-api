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
Route::get('clientNumberFormat/get', 'Web\clientController@getNumberFormat')->name('clients.getNumberFormat');
//CONTACT TYPE
Route::get('contactTypes/all', 'Web\ContactTypeController@all')->name('contactTypes.all');
//OFFICES
Route::get('offices/{contract}', 'Web\OfficeController@getForCountry')->name('offices.get');
//CONTRACTS
Route::get('contracts-office/{officeId}', 'Web\ContractController@getForOffice')->name('contracts.getForOffice');
Route::get('searchClients/{client?}', 'Web\ClientController@get')->name('searchClients.get');
Route::get('contract-allFiles/{id}/{type}', 'Web\ContractController@getFiles')->name('contracts.getFiles');
Route::get('precontract-allFiles/{id}/{type}', 'Web\PrecontractController@getFiles')->name('precontract.getFiles');
//ADMINISTRATION - RECEIVABLE **********************
Route::get('receivables/get/{receivableId}', 'Web\ReceivableController@getForId')->name('receivables.getForId');
Route::post('receivables/share', 'Web\ReceivableController@share')->name('receivables.share');
//BANK
Route::get('banks/country/{countryId}', 'Web\BankController@getForCountry')->name('banks.getForCountry');
Route::get('banks/account/{bankId}', 'Web\BankController@getAccount')->name('banks.account');
