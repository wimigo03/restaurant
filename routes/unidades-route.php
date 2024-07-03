<?php

Route::prefix('unidades')->name('unidades.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/index-after', 'UnidadController@indexAfter')->name('indexAfter')->middleware('can:unidades.index');
    Route::get('/', 'UnidadController@index')->name('index')->middleware('can:unidades.index');
    Route::get('/search', 'UnidadController@search')->name('search')->middleware('can:unidades.index');
    Route::get('/create', 'UnidadController@create')->name('create')->middleware('can:unidades.create');
    Route::post('/store', 'UnidadController@store')->name('store')->middleware('can:unidades.create');
});
