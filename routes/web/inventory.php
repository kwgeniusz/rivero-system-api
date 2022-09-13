<?php


//************* Service Equivalence ************//
Route::resource('service-equivalences', 'Web\Inventory\ServiceEquivalenceController')->except(['show']);
// Route::post('service-equivalences/by-company-to-link', 'Web\Inventory\ServiceEquivalenceController@index')->name('service-equivalences.index');


