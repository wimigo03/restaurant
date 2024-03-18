<?php

Route::prefix('balance-apertura')->name('balance.apertura.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/index-after', 'BalanceAperturaController@indexAfter')->name('indexAfter')->middleware('can:balance.apertura.index');
    Route::get('/{empresa_id}', 'BalanceAperturaController@index')->name('index')->middleware('can:balance.apertura.index');
    Route::get('create/{empresa_id}', 'BalanceAperturaController@create')->name('create')->middleware('can:balance.apertura.create');
    Route::post('/store', 'BalanceAperturaController@store')->name('store')->middleware('can:balance.apertura.create');
    /*Route::get('/search-tipo/{empresa_id}', 'PrecioProductoController@searchTipo')->name('search.tipo')->middleware('can:precio.productos.index');
    Route::get('/search-tipo-base/{empresa_id}', 'PrecioProductoController@searchTipoBase')->name('search.tipo.base')->middleware('can:precio.productos.index');
    Route::get('/show/{producto_id}', 'PrecioProductoController@show')->name('show')->middleware('can:precio.productos.show');
    Route::get('/get_subcategorias_precio_productos/{empresa_id}/{id}', 'PrecioProductoController@getSubCategorias')->name('get.subcategorias.precio.productos')->middleware('can:precio.productos.index');*/
});