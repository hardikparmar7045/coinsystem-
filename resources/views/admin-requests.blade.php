<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Coin Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">Coin Requests Admin Panel</div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Rejection Reason</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $request)
                            <tr>
                                <td>{{ $request->id }}</td>
                                <td>{{ $request->name }}</td>
                                <td>{{ $request->mobile }}</td>
                                <td>{{ $request->email }}</td>
                                <td>{{ $request->reason }}</td>
                                <td>
                                    <span class="badge {{ $request->status === 'Approved' ? 'text-bg-success' : ($request->status === 'Rejected' ? 'text-bg-danger' : 'text-bg-warning') }}">
                                        {{ $request->status }}
                                    </span>
                                </td>
                                <td>{{ $request->rejection_reason ?: '-' }}</td>
                                <td class="d-flex gap-2">
                                    <form method="POST" action="{{ route('coin-request.approve', $request->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" {{ $request->status === 'Approved' ? 'disabled' : '' }}>
                                            Approve
                                        </button>
                                    </form>

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#rejectModal"
                                        data-request-id="{{ $request->id }}"
                                        {{ $request->status === 'Rejected' ? 'disabled' : '' }}
                                    >
                                        Reject
                                    </button>
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

<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="rejectForm">
                @csrf
                <div class="modal-body">
                    <label for="rejection_reason" class="form-label">Rejection Reason</label>
                    <textarea
                        class="form-control @error('rejection_reason') is-invalid @enderror"
                        id="rejection_reason"
                        name="rejection_reason"
                        rows="4"
                        required
                    >{{ old('rejection_reason') }}</textarea>
                    @error('rejection_reason')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit Rejection</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const rejectModal = document.getElementById('rejectModal');
    const rejectForm = document.getElementById('rejectForm');

    rejectModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const requestId = button.getAttribute('data-request-id');

        rejectForm.action = `/admin/reject/${requestId}`;
    });
</script>
</body>
</html>
