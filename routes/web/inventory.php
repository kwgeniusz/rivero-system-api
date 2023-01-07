<?php

//--------------------INVENTORY MODULE ROUTES-------------------------//
Route::resource('services', 'Web\Inventory\ServiceController');


Route::prefix('inventory')->group(function () {

});
