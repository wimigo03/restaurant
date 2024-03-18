<?php

Route::prefix('estado-resultado')->name('estado.resultado.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/index-after', 'EstadoResultadoController@indexAfter')->name('indexAfter')->middleware('can:estado.resultado.index');
    Route::get('/{empresa_id}', 'EstadoResultadoController@index')->name('index')->middleware('can:estado.resultado.index');
    Route::get('/search/{empresa_id}', 'EstadoResultadoController@search')->name('search')->middleware('can:estado.resultado.index');
});