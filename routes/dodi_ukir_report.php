<?php

use Krishnawijaya\DodiUkirReport\Http\Controllers\DashboardController;
use Krishnawijaya\DodiUkirReport\Http\Controllers\PembelianController;
use Krishnawijaya\DodiUkirReport\Http\Controllers\PenjualanController;
use Krishnawijaya\DodiUkirReport\Http\Controllers\PersediaanController;

Voyager::routes();

Route::group(['as' => 'dodiukirreport.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

    Route::get('/pembelian/nota/{id}', [PembelianController::class, 'showBill'])->name('pembelian.bill');
    Route::get('/persediaan/nota/{id}', [PersediaanController::class, 'showBill'])->name('persediaan.bill');
    Route::get('/penjualan/nota/{id}', [PenjualanController::class, 'showBill'])->name('penjualan.bill');

    Route::get('/pembelian/laporan', [PembelianController::class, 'showReport'])->name('pembelian.report');
    Route::get('/persediaan/laporan', [PersediaanController::class, 'showReport'])->name('persediaan.report');
    Route::get('/penjualan/laporan', [PenjualanController::class, 'showReport'])->name('penjualan.report');

    Route::get('/pembelian/create', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::get('/persediaan/create', [PersediaanController::class, 'create'])->name('persediaan.create');
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
});
