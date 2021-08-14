<?php

//--------------------ACCOUNTING MODULE ROUTES-------------------------//

Route::prefix('accounting')->group(function () {
//************* Transaction ************
   Route::resource('transactions', 'Web\Accounting\TransactionController', ['as' => 'accounting']);
   Route::get('transacciones/actualizarSaldos', 'Web\Accounting\TransactionController@updateBalance');

   //************* General Ledger ************
   Route::resource('general-ledgers', 'Web\Accounting\GeneralLedgerController');
});



