<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('midtrans/notification', [\App\Http\Controllers\api\Midtrans::class, 'update']);
Route::post('midtrans/tested', [\App\Http\Controllers\api\Midtrans::class, 'tested']);
