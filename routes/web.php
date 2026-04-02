<?php

use App\Http\Controllers\CoinRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CoinRequestController::class, 'create'])->name('request.create');
Route::post('/request-coin', [CoinRequestController::class, 'store'])->name('request.store');

Route::get('/admin/requests', [CoinRequestController::class, 'adminIndex'])->name('admin.requests');
Route::post('/admin/approve/{id}', [CoinRequestController::class, 'approve'])->name('admin.approve');
Route::post('/admin/reject/{id}', [CoinRequestController::class, 'reject'])->name('admin.reject');

Route::get('/request-status', [CoinRequestController::class, 'statusForm'])->name('request.status.form');
Route::post('/request-status', [CoinRequestController::class, 'checkStatus'])->name('request.status.check');
