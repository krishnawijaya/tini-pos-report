<?php

Voyager::routes();

Route::group(['as' => 'dodiukirreport.', 'namespace' => 'Krishnawijaya\DodiUkirReport\Http\Controllers'], function () {
    Route::get('/dashboard', 'DashboardController@show')->name('dashboard');

    Route::get('/pembelian/nota/{id}', 'PembelianController@showBill')->name('pembelian.bill');
    Route::get('/persediaan/nota/{id}', 'PersediaanController@showBill')->name('persediaan.bill');
    Route::get('/penjualan/nota/{id}', 'PenjualanController@showBill')->name('penjualan.bill');

    Route::get('/pembelian', 'PembelianController@showReport')->name('pembelian.report');
    Route::get('/persediaan', 'PersediaanController@showReport')->name('persediaan.report');
    Route::get('/penjualan', 'PenjualanController@showReport')->name('penjualan.report');

    Route::get('/pembelian/create', 'PembelianController@create')->name('pembelian.create');
    Route::get('/persediaan/create', 'PersediaanController@create')->name('persediaan.create');
    Route::get('/penjualan/create', 'PenjualanController@create')->name('penjualan.create');

    Route::group(['prefix' => 'api', 'namespace' => 'Api', 'as' => 'api.'], function () {
        Route::get('/pembelian', 'PembelianController@index')->name('pembelian.index');
        Route::get('/persediaan', 'PersediaanController@index')->name('persediaan.index');
        Route::get('/penjualan', 'PenjualanController@index')->name('penjualan.index');

        Route::post('/pembelian', 'PembelianController@create')->name('pembelian.create');
        Route::post('/persediaan', 'PersediaanController@create')->name('persediaan.create');
        Route::post('/penjualan', 'PenjualanController@create')->name('penjualan.create');

        Route::put('/pembelian/{id}', 'PembelianController@update')->name('pembelian.update');
        Route::put('/persediaan/{id}', 'PersediaanController@update')->name('persediaan.update');
        Route::put('/penjualan/{id}', 'PenjualanController@update')->name('penjualan.update');
    });
});
