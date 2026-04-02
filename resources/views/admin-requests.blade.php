<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Admin Panel - Coin Requests</h3>
        <a href="{{ route('request.create') }}" class="btn btn-outline-dark">Back to Request Form</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Rejection Reason</th>
                    <th style="min-width: 280px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($requests as $requestItem)
                    <tr>
                        <td>{{ $requestItem->id }}</td>
                        <td>{{ $requestItem->name }}</td>
                        <td>{{ $requestItem->mobile }}</td>
                        <td>{{ $requestItem->email }}</td>
                        <td>{{ $requestItem->reason }}</td>
                        <td>
                            <span class="badge bg-{{ $requestItem->status === 'Approved' ? 'success' : ($requestItem->status === 'Rejected' ? 'danger' : 'warning text-dark') }}">
                                {{ $requestItem->status }}
                            </span>
                        </td>
                        <td>{{ $requestItem->rejection_reason ?? '-' }}</td>
                        <td>
                            <div class="d-flex flex-column gap-2">
                                <form action="{{ route('admin.approve', $requestItem->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" @disabled($requestItem->status === 'Approved')>Approve</button>
                                </form>

                                <form action="{{ route('admin.reject', $requestItem->id) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    <input type="text" name="rejection_reason" class="form-control form-control-sm @error('rejection_reason') is-invalid @enderror" placeholder="Rejection reason" required>
                                    <button type="submit" class="btn btn-sm btn-danger" @disabled($requestItem->status === 'Rejected')>Reject</button>
                                </form>
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
</body>
</html>
