<?php

Route::prefix('asiento-automatico')->name('asiento.automatico.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/index-after', 'AsientoAutomaticoController@indexAfter')->name('indexAfter')->middleware('can:asiento.automatico.index');
    Route::get('/{empresa_id}', 'AsientoAutomaticoController@index')->name('index')->middleware('can:asiento.automatico.index');
    Route::get('/search/{empresa_id}', 'AsientoAutomaticoController@search')->name('search')->middleware('can:asiento.automatico.index');
    Route::get('/create/{empresa_id}', 'AsientoAutomaticoController@create')->name('create')->middleware('can:asiento.automatico.create');
    Route::post('/store', 'AsientoAutomaticoController@store')->name('store')->middleware('can:asiento.automatico.create');
    Route::get('/editar/{asiento_automatico_id}', 'AsientoAutomaticoController@editar')->name('editar')->middleware('can:asiento.automatico.editar');
    Route::post('/update', 'AsientoAutomaticoController@update')->name('update')->middleware('can:asiento.automatico.editar');
    Route::get('/habilitar/{asiento_automatico_id}', 'AsientoAutomaticoController@habilitar')->name('habilitar')->middleware('can:asiento.automatico.habilitar');
    Route::get('/deshabilitar/{asiento_automatico_id}', 'AsientoAutomaticoController@deshabilitar')->name('deshabilitar')->middleware('can:asiento.automatico.habilitar');
});
