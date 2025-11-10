<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::get('/balance/{user_id}', [UserController::class, 'balance'])->name('user.balance');

Route::post('/deposit', [TransactionController::class, 'deposit'])->name('transaction.deposit');
Route::post('/withdraw', [TransactionController::class, 'withdraw'])->name('transaction.withdraw');
Route::post('/transfer', [TransactionController::class, 'transfer'])->name('transaction.transfer');
