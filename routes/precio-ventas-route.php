<?php

Route::prefix('precio-ventas')->name('precio.ventas.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/index-after', 'PrecioVentaController@indexAfter')->name('indexAfter')->middleware('can:precio.ventas.index');
    Route::get('/index/{empresa_id}', 'PrecioVentaController@index')->name('index')->middleware('can:precio.ventas.index');
    Route::get('/search/{empresa_id}', 'PrecioVentaController@search')->name('search')->middleware('can:precio.ventas.index');
    Route::get('/create/{empresa_id}/{tipo_precio_id}', 'PrecioVentaController@create')->name('create')->middleware('can:precio.ventas.create');
    Route::post('/store', 'PrecioVentaController@store')->name('store')->middleware('can:precio.ventas.create');
    Route::get('/editar/{id}', 'PrecioVentaController@editar')->name('editar')->middleware('can:precio.ventas.editar');
    Route::post('/update', 'PrecioVentaController@update')->name('update')->middleware('can:precio.ventas.editar');
    Route::get('/habilitar/{id}', 'PrecioVentaController@habilitar')->name('habilitar')->middleware('can:precio.ventas.habilitar');
    Route::get('/deshabilitar/{id}', 'PrecioVentaController@deshabilitar')->name('deshabilitar')->middleware('can:precio.ventas.habilitar');
});