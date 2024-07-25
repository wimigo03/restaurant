<?php

Route::prefix('mesas')->name('mesas.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/index-after', 'MesaController@indexAfter')->name('indexAfter')->middleware('can:mesas.index');
    Route::get('/index', 'MesaController@index')->name('index')->middleware('can:mesas.index');
    Route::get('/indexAjax', 'MesaController@indexAjax')->name('indexAjax')->middleware('can:mesas.index');
    Route::get('/search', 'MesaController@search')->name('search')->middleware('can:mesas.index');
    Route::get('/create', 'MesaController@create')->name('create')->middleware('can:mesas.create');
    Route::get('/get_datos_by_sucursal', 'MesaController@getDatosBySucursal')->name('get.datos.by.sucursal')->middleware('can:mesas.create');
    Route::get('/get_datos_by_empresa', 'MesaController@getDatosByEmpresa')->name('get.datos.by.empresa')->middleware('can:mesas.create');
    Route::post('/store', 'MesaController@store')->name('store')->middleware('can:mesas.create');
    Route::get('/editar/{id}', 'MesaController@editar')->name('editar')->middleware('can:mesas.editar');
    Route::post('/update', 'MesaController@update')->name('update')->middleware('can:mesas.editar');
    Route::get('/habilitar/{id}', 'MesaController@habilitar')->name('habilitar')->middleware('can:mesas.habilitar');
    Route::get('/deshabilitar/{id}', 'MesaController@deshabilitar')->name('deshabilitar')->middleware('can:mesas.habilitar');
    Route::get('/setting/{sucursal_id}', 'MesaController@setting')->name('setting')->middleware('can:mesas.setting');
    Route::get('/get_mesas_by_zona', 'MesaController@getMesasByZona')->name('get.mesas.by.zona');
    Route::post('/store_cargar_mesa', 'MesaController@storeCargarMesa')->name('store.cargar')->middleware('can:mesas.setting');

    Route::get('/get_eliminar', 'MesaController@getEliminar')->name('get.eliminar')->middleware('can:mesas.create');
    Route::get('/get_mesas', 'MesaController@getMesas')->name('get.mesas')->middleware('can:mesas.create');
    Route::get('/get_add', 'MesaController@getAdd')->name('get.add')->middleware('can:mesas.create');
    Route::get('/get_update_fc', 'MesaController@getUpdateFc')->name('get.update.fc')->middleware('can:mesas.create');
    Route::get('/get_posicion', 'MesaController@getPosicion')->name('get.posicion')->middleware('can:mesas.create');
});
