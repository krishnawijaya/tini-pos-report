<?php

use Krishnawijaya\DodiUkirReport\Http\Controllers\Controller;

Route::group(['as' => 'dodiukirreport.'], function () {
    Route::get('/penjualan/nota/{model}', [Controller::class, 'showBill']);
    Route::get('/persediaan/nota/{model}', [Controller::class, 'showBill']);
    Route::get('/pembelian/nota/{model}', [Controller::class, 'showBill']);

    Route::get('/pembelian/report/{model}', [Controller::class, 'showReport']);
    Route::get('/penjualan/report/{model}', [Controller::class, 'showReport']);
    Route::get('/persediaan/report/{model}', [Controller::class, 'showReport']);
});
