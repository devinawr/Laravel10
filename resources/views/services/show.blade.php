<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $service->service_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">{{ $service->service_name }}</h2>

                        <div class="mb-3">
                            <label class="form-label"><strong>Category:</strong></label>
                            <p>{{ $service->category->category_name ?? 'N/A' }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Description:</strong></label>
                            <p>{{ $service->description }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Availability:</strong></label>
                            <p>{{ $service->availability }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><strong>Price:</strong></label>
                            <p class="text-success"><strong>Rp {{ number_format($service->price, 0, ',', '.') }}</strong></p>
                        </div>

                        <a href="{{ route('services.index') }}" class="btn btn-secondary">Back to Services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>