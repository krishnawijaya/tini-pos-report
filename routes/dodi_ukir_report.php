<?php

use Krishnawijaya\DodiUkirReport\Http\Controllers\PembelianController;
use Krishnawijaya\DodiUkirReport\Http\Controllers\PenjualanController;
use Krishnawijaya\DodiUkirReport\Http\Controllers\PersediaanController;

Route::group(['as' => 'dodiukirreport.'], function () {
    Route::get('/pembelian/nota/{id}', [PembelianController::class, 'showBill']);
    Route::get('/persediaan/nota/{id}', [PersediaanController::class, 'showBill']);
    Route::get('/penjualan/nota/{id}', [PenjualanController::class, 'showBill']);

    Route::get('/pembelian/report/{id}', [PembelianController::class, 'showReport']);
    Route::get('/persediaan/report/{id}', [PersediaanController::class, 'showReport']);
    Route::get('/penjualan/report/{id}', [PenjualanController::class, 'showReport']);
});
