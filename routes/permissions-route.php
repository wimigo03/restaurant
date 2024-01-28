<?php

Route::prefix('permissions')->name('permissions.')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/', 'PermissionController@index')->name('index')->middleware('can:permissions.index');
    Route::get('/search', 'PermissionController@search')->name('search')->middleware('can:permissions.index');
    Route::get('/create', 'PermissionController@create')->name('create')->middleware('can:permissions.create');
    Route::post('/store', 'PermissionController@store')->name('store')->middleware('can:permissions.create');
});