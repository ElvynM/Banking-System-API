<?php

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/accounts',[AccountsController::class,'create']);
Route::get('/accounts/{number_account}',[AccountsController::class,'show']);

Route::post('/transaction',[TransactionController::class,'create']);
