<?php

namespace App\Http\Controllers;

use App\Models\CoinRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoinRequestController extends Controller
{
    public function create(): View
    {
        return view('request-form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'reason' => ['required', 'string'],
        ]);

        CoinRequest::create([
            ...$validated,
            'status' => 'Pending',
        ]);

        return redirect()->route('request.create')->with('success', 'Coin request submitted successfully.');
    }

    public function adminIndex(): View
    {
        $requests = CoinRequest::latest()->get();

        return view('admin-requests', compact('requests'));
    }

    public function approve(int $id): RedirectResponse
    {
        $coinRequest = CoinRequest::findOrFail($id);
        $coinRequest->update([
            'status' => 'Approved',
            'rejection_reason' => null,
        ]);

        return redirect()->route('admin.requests')->with('success', 'Request approved successfully.');
    }

    public function reject(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string'],
        ]);

        $coinRequest = CoinRequest::findOrFail($id);
        $coinRequest->update([
            'status' => 'Rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->route('admin.requests')->with('success', 'Request rejected successfully.');
    }

    public function statusForm(): View
    {
        return view('request-status');
    }

    public function checkStatus(Request $request): View
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $coinRequest = CoinRequest::where('email', $validated['email'])->latest()->first();

        return view('request-status', [
            'coinRequest' => $coinRequest,
            'email' => $validated['email'],
        ]);
    }
}
