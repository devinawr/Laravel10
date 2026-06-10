<!DOCTYPE html>
<html>
<head>
    <title>Most Expensive Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Most Expensive Service in Each Category</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Service Name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
           @foreach($categories as $category)
    <tr>
        <td>{{ $category->name }}</td>

        @php
        $service = $category->services->sortByDesc('price')->first();
        @endphp

        @if($service)
            <td>{{ $service->name }}</td>
            <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
        @else
            <td colspan="2" class="text-center">-</td>
        @endif
    </tr>
@endforeach
        </tbody>
    </table>
</div>

</body>
</html>