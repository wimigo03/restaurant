<?php

Route::prefix('empresas')->name('empresas.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/{cliente_id}', 'EmpresaController@index')->name('index');//->middleware('can:users.index');
    Route::get('/search', 'EmpresaController@search')->name('search');//->middleware('can:users.index');
    Route::get('/create/{cliente_id}', 'EmpresaController@create')->name('create');//->middleware('can:users.index');
    Route::post('/store', 'EmpresaController@store')->name('store');//->middleware('can:users.index');
    Route::get('/editar/{empresa_id}', 'EmpresaController@editar')->name('editar');//->middleware('can:users.index');
    Route::post('/update', 'EmpresaController@update')->name('update');//->middleware('can:users.index');
});