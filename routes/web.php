<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/coin-requests', function (Request $request) {
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'amount' => ['required', 'integer', 'min:1'],
        'reason' => ['required', 'string', 'max:500'],
    ]);

    return back()->with('success', "Coin request submitted for {$validated['name']} ({$validated['amount']} coins).");
})->name('coin-requests.store');
