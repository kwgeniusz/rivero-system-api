<?php

//--------------------INVENTORY MODULE ROUTES-------------------------//
Route::resource('services', 'Web\Inventory\ServiceController');
Route::resource('service-categories', 'Web\Inventory\ServiceCategoryController');


Route::prefix('inventory')->group(function () {

});
