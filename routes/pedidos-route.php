<?php

Route::prefix('pedidos')->name('pedidos.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    //Route::get('/', 'PedidoController@index')->name('index')->middleware('can:pedidos.index');
    Route::get('/create', 'PedidoController@create')->name('create')->middleware('can:pedidos.create');
    Route::get('/get_sucursales_by_empresa', 'PedidoController@getSucursalesByEmpresa')->name('get.sucursales.by.empresa')->middleware('can:pedidos.create');
    Route::get('/get_zonas_by_sucursales', 'PedidoController@getZonasBySucursales')->name('get.zonas.by.sucursales')->middleware('can:pedidos.create');
    Route::get('/get_datos_by_zona', 'PedidoController@getDatosByZona')->name('get.datos.by.zona')->middleware('can:pedidos.create');
    Route::get('/get_mesas', 'PedidoController@getMesas')->name('get.mesas')->middleware('can:pedidos.create');
    Route::get('/cargar_pedido/{mesa_id}', 'PedidoController@cargarPedido')->name('get.cargar.pedido')->middleware('can:pedidos.create');
    Route::get('/get_datos_para_pedido', 'PedidoController@getDatosParaPedido')->name('get.datos.para.pedido')->middleware('can:pedidos.create');
    Route::get('/get_update_pedido', 'PedidoController@getUpdatePedido')->name('get.update.pedido')->middleware('can:pedidos.create');
    Route::post('/store', 'PedidoController@store')->name('store')->middleware('can:pedidos.create');
    Route::post('/pendiente', 'PedidoController@pendiente')->name('pendiente')->middleware('can:pedidos.create');
    Route::post('/anular', 'PedidoController@anular')->name('anular')->middleware('can:pedidos.create');
});
