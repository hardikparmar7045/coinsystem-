<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Coin Request Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-dark">Check Request Status</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('coin-request.status') }}" class="mb-4">
                        <div class="mb-3">
                            <label for="identifier" class="form-label">Email or Mobile</label>
                            <input
                                type="text"
                                class="form-control @error('identifier') is-invalid @enderror"
                                id="identifier"
                                name="identifier"
                                value="{{ request('identifier') }}"
                                placeholder="Enter your email or mobile"
                                required
                            >
                            @error('identifier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-info">Check Status</button>
                        <a href="{{ route('coin-request.create') }}" class="btn btn-outline-secondary">New Request</a>
                    </form>

                    @if (request()->filled('identifier'))
                        @if ($coinRequest)
                            <div class="alert alert-secondary mb-0">
                                <p class="mb-2"><strong>Name:</strong> {{ $coinRequest->name }}</p>
                                <p class="mb-2"><strong>Status:</strong>
                                    <span class="badge {{ $coinRequest->status === 'Approved' ? 'text-bg-success' : ($coinRequest->status === 'Rejected' ? 'text-bg-danger' : 'text-bg-warning') }}">
                                        {{ $coinRequest->status }}
                                    </span>
                                </p>

                                @if ($coinRequest->status === 'Rejected')
                                    <p class="mb-0"><strong>Rejection Reason:</strong> {{ $coinRequest->rejection_reason }}</p>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">No request found for this email/mobile.</div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
