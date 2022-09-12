<?php


//************* Service Equivalence ************//
Route::get('service-equivalences/{companyToLink}', 'Web\Inventory\ServiceEquivalenceController@index');
Route::resource('service-equivalences', 'Web\Inventory\ServiceEquivalenceController');
