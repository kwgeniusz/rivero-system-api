<?php


Route::prefix('intercompany')->group(function () {

    //************* Service Equivalence ************//
    Route::resource('service-equivalences', 'Web\Intercompany\Equivalence\ServiceEquivalenceController')->except(['show']);
    // Route::post('service-equivalences/by-company-to-link', 'Web\Intercompany\Equivalence\ServiceEquivalenceController@index')->name('service-equivalences.index');
    
    //======================== Proposal ===========================//
    //************* Preloaded Time Frame ************//
    Route::resource('time-frame-equivalences', 'Web\Intercompany\Equivalence\TimeFrameEquivalenceController')->except(['show']);
    // Route::post('service-equivalences/by-company-to-link', 'Web\Intercompany\Equivalence\TimeFrameController@index')->name('service-equivalences.index');
    
    //************* Preloaded Note ************//
    Route::resource('note-equivalences', 'Web\Intercompany\Equivalence\NoteEquivalenceController')->except(['show']);
    // Route::post('service-equivalences/by-company-to-link', 'Web\Intercompany\Equivalence\NoteEquivalenceController@index')->name('service-equivalences.index');
  
    //************* Preloaded Term ************//
    Route::resource('term-equivalences', 'Web\Intercompany\Equivalence\TermEquivalenceController')->except(['show']);
    // Route::post('service-equivalences/by-company-to-link', 'Web\Intercompany\Equivalence\ServiceEquivalenceController@index')->name('service-equivalences.index');

//**************************************************************************
//***************************** INTERCOMPANY ****************************
//***************************************************************************
    Route::get('export/invoice/{id}', function ($id) { return view('module_intercompany.export.invoice', compact('id')); })->name('intercompany.export.invoice.prepareData');
    Route::post('export/invoice', 'Web\Intercompany\Export\InvoiceExportController@sendData')->name('intercompany.export.invoice.sendData');

});

