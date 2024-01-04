<?php

Voyager::routes();

Route::group(['as' => 'tiniposreport.', 'namespace' => 'KrishnaWijaya\TiniPosReport\Http\Controllers', 'middleware' => 'admin.user'], function () {
    Route::get('/logout', 'VoyagerController@logout');
    Route::get('/dashboard', 'DashboardController@show')->name('dashboard');

    Route::get('/api/dashboard/topbar', 'DashboardController@getTopBarData')->name('api.dashboard.topbar');
    Route::get('/api/dashboard/chart', 'DashboardController@getChartData')->name('api.dashboard.chart');

    Route::redirect('/pembelian/nota', '/pembelian', 301);
    Route::redirect('/persediaan/laporan', '/persediaan', 301);
    Route::redirect('/penjualan/nota', '/penjualan', 301);
    Route::redirect('/stock-opname/laporan', '/stock-opname', 301);

    Route::get('/pembelian/nota/{id}', 'PembelianController@showDetails')->name('pembelian.details');
    Route::get('/persediaan/laporan/{id}', 'PersediaanController@showDetails')->name('persediaan.details');
    Route::get('/penjualan/nota/{id}', 'PenjualanController@showDetails')->name('penjualan.details');
    Route::get('/stock-opname/laporan/{id}', 'StockOpnameController@showDetails')->name('stock-opname.details');

    Route::get('/pembelian', 'PembelianController@showReport')->name('pembelian.report');
    Route::get('/persediaan', 'PersediaanController@showReport')->name('persediaan.report');
    Route::get('/penjualan', 'PenjualanController@showReport')->name('penjualan.report');
    Route::get('/stock-opname', 'StockOpnameController@showReport')->name('stock-opname.report');

    Route::get('/pembelian/create', 'PembelianController@create')->name('pembelian.create');
    Route::get('/penjualan/create', 'PenjualanController@create')->name('penjualan.create');
    Route::get('/stock-opname/create', 'StockOpnameController@create')->name('stock-opname.create');

    Route::group(['prefix' => 'api', 'namespace' => 'Api', 'as' => 'api.'], function () {
        Route::get('/barang', 'BarangController@index')->name('barang.index');
        Route::get('/supplier', 'SupplierController@index')->name('supplier.index');

        Route::get('/pembelian', 'PembelianController@index')->name('pembelian.index');
        Route::get('/persediaan', 'PersediaanController@index')->name('persediaan.index');
        Route::get('/penjualan', 'PenjualanController@index')->name('penjualan.index');
        Route::get('/stock-opname', 'StockOpnameController@index')->name('stock-opname.index');

        Route::get('/pembelian/{id}', 'PembelianController@show')->name('pembelian.show');
        Route::get('/persediaan/{id}', 'PersediaanController@show')->name('persediaan.show');
        Route::get('/penjualan/{id}', 'PenjualanController@show')->name('penjualan.show');
        Route::get('/stock-opname/{id}', 'StockOpnameController@show')->name('stock-opname.show');

        Route::post('/pembelian', 'PembelianController@create')->name('pembelian.create');
        Route::post('/penjualan', 'PenjualanController@create')->name('penjualan.create');
        Route::post('/stock-opname', 'StockOpnameController@create')->name('stock-opname.create');
    });
});
