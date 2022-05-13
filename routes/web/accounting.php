<?php

//--------------------ACCOUNTING MODULE ROUTES-------------------------//
Route::prefix('accounting')->group(function () {
   
//************* Transaction Header ************
 Route::resource('transaction-headers', 'Web\Accounting\TransactionHeaderController', ['as' => 'accounting']);
 Route::get('transacciones-encabezado/actualizarSaldos', 'Web\Accounting\TransactionHeaderController@updateBalance');
 Route::get('transacciones-encabezado/{id}/validar', 'Web\Accounting\TransactionHeaderController@validateHeader');
   // Route::post('transaction-headers/search-between-dates', 'Web\Accounting\TransactionHeaderController@searchBetweenDates')->name('transaction-headers.searchBetweenDates');
//************* Transaction ************
  Route::resource('transactions', 'Web\Accounting\TransactionController', ['as' => 'accounting']);


//************* Temporal Transaction Header ************
Route::resource('transaction-headers-tmp', 'Web\Accounting\TransactionHeaderTmpController', ['as' => 'accounting']);
//************* Temporal Transaction ************
Route::resource('transactions-tmp', 'Web\Accounting\TransactionTmpController', ['as' => 'accounting']);
//************* General Ledger ************
Route::resource('general-ledgers', 'Web\Accounting\GeneralLedgerController');

//************* Auxiliary Book ************
Route::resource('auxiliary-books', 'Web\Accounting\AuxiliaryBookController');

//************* Close Accounting Year ************
Route::get('close-year', 'Web\Accounting\GeneralLedgerController@closeYear');

//************* Reports ************
   Route::post('reports/entries', 'Report\Pdf\AccountingControllerPDF@printEntries')->name('reports.acc-entries');
   Route::post('reports/general-ledger', 'Report\Pdf\AccountingControllerPDF@printGeneralLedger')->name('reports.acc-general-ledger');

});