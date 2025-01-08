<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\api\buzzerpanel;
use App\Http\Controllers\api\irvankede;


Auth::routes();

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('panel');
    } else {
        return redirect()->route('login');
    }
});


Route::get('/panel', [PanelController::class, 'index'])->name('panel')->middleware('auth');
Route::get('/orders', [OrderController::class, 'index'])->name('orders')->middleware('auth');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
Route::get('/orders/history', [OrderController::class, 'show'])->name('orders.history')->middleware('auth');

Route::get('/layanan2', [irvankede::class, 'LayanaIrvankede'])->name('layanan2')->middleware('auth');
Route::get('/layanan2/history', [irvankede::class, 'ShowIrvanKede'])->name('layanan2.history')->middleware('auth');
Route::post('/layanan2', [irvankede::class, 'StoreIrvanKede'])->name('layanan2.store')->middleware('auth');

Route::get('/topup', [TopupController::class, 'topupHistory'])->name('topup')->middleware('auth');
Route::post('/topup', [TopupController::class, 'topup'])->middleware('auth');
Route::get('/topup/transaksi/{id_transaksi}', [TopupController::class, 'transaksi'])->name('topup.transaksi')->middleware('auth');

Route::get('/setting', [SettingController::class, 'index'])->name('setting')->middleware('auth');
Route::post('/setting', [SettingController::class, 'update'])->name('setting.update')->middleware('auth');

Route::get('/website', [WebSettingController::class, 'index'])->name('website')->middleware('auth');
Route::post('/website', [WebSettingController::class, 'update'])->name('website.update')->middleware('auth');

Route::get('/buzzerpanel', [buzzerpanel::class, 'index'])->name('buzzerpanel')->middleware('auth');
Route::post('/buzzerpanel', [buzzerpanel::class, 'update'])->name('buzzerpanel.update')->middleware('auth');

Route::get('/irvankede', [irvankede::class, 'index'])->name('irvankede')->middleware('auth');
Route::post('/irvankede', [irvankede::class, 'update'])->name('irvankede.update')->middleware('auth');
