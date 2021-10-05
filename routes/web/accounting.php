<?php

//--------------------ACCOUNTING MODULE ROUTES-------------------------//

Route::prefix('accounting')->group(function () {
//************* Transaction Header ************
   Route::resource('transaction-headers', 'Web\Accounting\TransactionHeaderController', ['as' => 'accounting']);
   Route::get('transacciones-encabezado/actualizarSaldos', 'Web\Accounting\TransactionHeaderController@updateBalance');
   // Route::post('transaction-headers/search-between-dates', 'Web\Accounting\TransactionHeaderController@searchBetweenDates')->name('transaction-headers.searchBetweenDates');
//************* Transaction ************
   Route::resource('transactions', 'Web\Accounting\TransactionController', ['as' => 'accounting']);
//************* General Ledger ************
   Route::resource('general-ledgers', 'Web\Accounting\GeneralLedgerController');
//************* Reports ************
   Route::post('reports/entries', 'Report\Pdf\AccountingControllerPDF@printEntries')->name('reports.acc-entries');
   Route::post('reports/general-ledger', 'Report\Pdf\AccountingControllerPDF@printGeneralLedger')->name('reports.acc-general-ledger');



});



