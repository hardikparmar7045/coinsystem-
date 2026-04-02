<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Request Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('coin-request.create') }}">Coin Request System</a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('coin-request.create') }}" class="btn btn-outline-light btn-sm">Request Form</a>
            <a href="{{ route('coin-request.admin.index') }}" class="btn btn-dark btn-sm">Admin Panel</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-info text-dark fw-semibold">Check Coin Request Status</div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Please fix the following:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('coin-request.status.check') }}" class="row g-3">
                        @csrf
                        <div class="col-md-9">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button class="btn btn-info" type="submit">Check Status</button>
                        </div>
                    </form>

                    @if (request()->isMethod('post'))
                        <hr>
                        @if ($coinRequest)
                            <div class="alert alert-success mb-3">Request found successfully.</div>
                            @php
                                $statusClass = $coinRequest->status === 'Approved'
                                    ? 'bg-success'
                                    : ($coinRequest->status === 'Rejected' ? 'bg-danger' : 'bg-warning text-dark');
                            @endphp
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Name:</strong> {{ $coinRequest->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $coinRequest->email }}</li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>Status:</strong>
                                    <span class="badge {{ $statusClass }} px-3 py-2">{{ $coinRequest->status }}</span>
                                </li>
                                @if ($coinRequest->status === 'Rejected')
                                    <li class="list-group-item text-danger"><strong>Rejection Reason:</strong> {{ $coinRequest->rejection_reason }}</li>
                                @endif
                            </ul>
                        @else
                            <div class="alert alert-warning mt-3 mb-0">No request found for this email.</div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
