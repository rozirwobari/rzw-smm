<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/midtrans/update', [\App\Http\Controllers\api\Midtrans::class, 'update']);
