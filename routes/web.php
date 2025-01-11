<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\WebSettingController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\api\buzzerpanel;
use App\Http\Controllers\api\irvankede;
use App\Http\Controllers\ManageUsers;


Auth::routes();

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('panel');
    } else {
        return redirect()->route('login');
    }
});


Route::get('/panel', [PanelController::class, 'index'])->name('panel')->middleware('auth');
Route::get('/transaksi', [PanelController::class, 'AllTransaksi'])->name('transaksi')->middleware('auth');
Route::get('/users', [ManageUsers::class, 'index'])->name('users.manage')->middleware('auth');
Route::get('/users/edit/{user_id}', [ManageUsers::class, 'show'])->name('users.edit')->middleware('auth');
Route::post('/users/saved/{user_id}', [ManageUsers::class, 'update'])->name('users.saved')->middleware('auth');

Route::get('/layanan1', [irvankede::class, 'LayanaIrvankede'])->name('layanan1')->middleware('auth');
Route::get('/layanan1/history', [irvankede::class, 'ShowIrvanKede'])->name('layanan1.history')->middleware('auth');
Route::post('/layanan1', [irvankede::class, 'StoreIrvanKede'])->name('layanan1.store')->middleware('auth');

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
