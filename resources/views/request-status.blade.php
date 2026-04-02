<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0">Check Coin Request Status</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('request.status.check') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email ?? '') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Check Status</button>
                        <a href="{{ route('request.create') }}" class="btn btn-outline-dark">Back to Form</a>
                    </form>

                    @isset($coinRequest)
                        @if($coinRequest)
                            <div class="alert alert-info mb-0">
                                <h5 class="mb-2">Status: {{ $coinRequest->status }}</h5>
                                @if($coinRequest->status === 'Rejected')
                                    <p class="mb-0"><strong>Rejection Reason:</strong> {{ $coinRequest->rejection_reason }}</p>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning mb-0">No request found for {{ $email }}.</div>
                        @endif
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
