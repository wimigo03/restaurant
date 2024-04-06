<?php

Route::prefix('apertura-cierre')->name('apertura.cierre.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/index-after', 'AperturaCierreController@indexAfter')->name('indexAfter')->middleware('can:apertura.cierre.index');
    Route::get('/{empresa_id}', 'AperturaCierreController@index')->name('index')->middleware('can:apertura.cierre.index');
    Route::get('/search/{empresa_id}', 'AperturaCierreController@search')->name('search')->middleware('can:apertura.cierre.index');
    Route::get('/create/{empresa_id}', 'AperturaCierreController@create')->name('create')->middleware('can:apertura.cierre.create');
    Route::post('/store', 'AperturaCierreController@store')->name('store')->middleware('can:apertura.cierre.create');
    /*Route::get('/editar/{asiento_automatico_id}', 'AsientoAutomaticoController@editar')->name('editar')->middleware('can:asiento.automatico.editar');
    Route::post('/update', 'AsientoAutomaticoController@update')->name('update')->middleware('can:asiento.automatico.editar');
    Route::get('/habilitar/{asiento_automatico_id}', 'AsientoAutomaticoController@habilitar')->name('habilitar')->middleware('can:asiento.automatico.habilitar');
    Route::get('/deshabilitar/{asiento_automatico_id}', 'AsientoAutomaticoController@deshabilitar')->name('deshabilitar')->middleware('can:asiento.automatico.habilitar');*/
});
