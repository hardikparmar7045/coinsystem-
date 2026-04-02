<?php

use App\Http\Controllers\CoinRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CoinRequestController::class, 'create'])->name('coin-request.create');
Route::post('/request-coin', [CoinRequestController::class, 'store'])->name('coin-request.store');
Route::get('/admin/requests', [CoinRequestController::class, 'adminIndex'])->name('coin-request.admin.index');
Route::post('/admin/approve/{id}', [CoinRequestController::class, 'approve'])->name('coin-request.approve');
Route::post('/admin/reject/{id}', [CoinRequestController::class, 'reject'])->name('coin-request.reject');
Route::get('/request-status', [CoinRequestController::class, 'checkStatus'])->name('coin-request.status.form');
Route::post('/request-status', [CoinRequestController::class, 'checkStatus'])->name('coin-request.status.check');
