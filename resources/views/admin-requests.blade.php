<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Coin Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-semibold" href="{{ route('coin-request.create') }}">Coin Request System</a>
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('coin-request.create') }}" class="btn btn-outline-light btn-sm">Request Form</a>
            <a href="{{ route('coin-request.status.form') }}" class="btn btn-outline-light btn-sm">Check Status</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white fw-semibold">Admin Panel: Coin Requests</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Action failed:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Rejection Reason</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($requests as $requestItem)
                        <tr>
                            <td>{{ $requestItem->id }}</td>
                            <td>{{ $requestItem->name }}</td>
                            <td>{{ $requestItem->mobile }}</td>
                            <td>{{ $requestItem->email }}</td>
                            <td style="min-width: 240px;">{{ $requestItem->reason }}</td>
                            <td>
                                @php
                                    $badgeClass = $requestItem->status === 'Approved'
                                        ? 'bg-success'
                                        : ($requestItem->status === 'Rejected' ? 'bg-danger' : 'bg-warning text-dark');
                                @endphp
                                <span class="badge {{ $badgeClass }} px-3 py-2">{{ $requestItem->status }}</span>
                            </td>
                            <td>{{ $requestItem->rejection_reason ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <form action="{{ route('coin-request.approve', $requestItem->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" {{ $requestItem->status === 'Approved' ? 'disabled' : '' }}>
                                            Approve
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $requestItem->id }}" {{ $requestItem->status === 'Rejected' ? 'disabled' : '' }}>
                                        Reject
                                    </button>
                                </div>

                                <div class="modal fade" id="rejectModal{{ $requestItem->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reject Request #{{ $requestItem->id }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('coin-request.reject', $requestItem->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <label class="form-label">Rejection Reason</label>
                                                    <textarea name="rejection_reason" class="form-control" rows="4" required></textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Confirm Reject</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No requests found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
