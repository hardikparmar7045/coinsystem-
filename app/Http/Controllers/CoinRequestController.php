<?php

namespace App\Http\Controllers;

use App\Models\CoinRequest;
use Illuminate\Http\Request;

class CoinRequestController extends Controller
{
    public function create()
    {
        return view('request-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'reason' => ['required', 'string'],
        ]);

        CoinRequest::create($validated + [
            'status' => 'Pending',
        ]);

        return redirect()
            ->route('coin-request.create')
            ->with('success', 'Coin request submitted successfully.');
    }

    public function adminIndex()
    {
        $requests = CoinRequest::latest()->get();

        return view('admin-requests', compact('requests'));
    }

    public function approve($id)
    {
        $coinRequest = CoinRequest::findOrFail($id);
        $coinRequest->update([
            'status' => 'Approved',
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('coin-request.admin-index')
            ->with('success', 'Request approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string'],
        ]);

        $coinRequest = CoinRequest::findOrFail($id);
        $coinRequest->update([
            'status' => 'Rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()
            ->route('coin-request.admin-index')
            ->with('success', 'Request rejected successfully.');
    }

    public function checkStatus(Request $request)
    {
        $coinRequest = null;

        if ($request->filled('identifier')) {
            $validated = $request->validate([
                'identifier' => ['required', 'string', 'max:255'],
            ]);

            $identifier = $validated['identifier'];

            $coinRequest = CoinRequest::query()
                ->where('email', $identifier)
                ->orWhere('mobile', $identifier)
                ->latest()
                ->first();
        }

        return view('request-status', compact('coinRequest'));
    }
}
