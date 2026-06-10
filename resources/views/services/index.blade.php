@extends('layouts.adminlte4')
@section('title', 'Service Page')
@section('sidebar-service', 'active')
@section('content')
    <div class="mb-3">
        <h2>Service Table</h2>
    </div>

    <div id="ajaxMessage"></div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Service Name</th>
                <th>Description</th>
                <th>Availability</th>
                <th>Price</th>
                <th>Category ID</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($services as $service)
            <tr id="tr_{{ $service->id }}">
                <td>{{ $service->id }}</td>
                <td id="td_name_{{ $service->id }}">
                    <a href="{{ route('services.show', $service->id) }}">
                        {{ $service->service_name }}
                    </a>
                </td>
                <td id="td_description_{{ $service->id }}">{{ $service->description }}</td>
                <td id="td_availability_{{ $service->id }}">{{ $service->availability }}</td>
                <td id="td_price_{{ $service->id }}">{{ $service->price }}</td>
                <td id="td_category_id_{{ $service->id }}">{{ $service->category_id }}</td>
                <td id="td_category_name_{{ $service->id }}">{{ $service->category->category_name }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-info" onclick="getServiceEditFormB({{ $service->id }})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Delete service {{ $service->service_name }}?')) deleteService({{ $service->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @push('modal')
        <div class="modal fade" id="modalEditB" tabindex="-1" aria-labelledby="modalEditBLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="modalContentB"></div>
            </div>
        </div>
    @endpush

    @push('script')
        <script>
            function getServiceEditFormB(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("services.getEditFormB") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        $('#modalContentB').html(data.msg);
                        var modalEditB = new bootstrap.Modal(document.getElementById('modalEditB'));
                        modalEditB.show();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error loading edit form');
                    }
                });
            }

            function saveServiceDataUpdate(id) {
                var name = $('#sname_' + id).val();
                var description = $('#sdescription_' + id).val();
                var availability = $('#savailability_' + id).val();
                var price = $('#sprice_' + id).val();
                var categoryId = $('#scategory_' + id).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("services.saveDataUpdate") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                        'service_name': name,
                        'description': description,
                        'availability': availability,
                        'price': price,
                        'category_id': categoryId
                    },
                    success: function(data) {
                        if (data.status === 'oke') {
                            $('#td_name_' + id).html(name);
                            $('#td_description_' + id).html(description);
                            $('#td_availability_' + id).html(availability);
                            $('#td_price_' + id).html(price);
                            $('#td_category_id_' + id).html(categoryId);
                            var modalEl = document.getElementById('modalEditB');
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error updating service');
                    }
                });
            }

            function deleteService(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("services.deleteData") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 'oke') {
                            $('#tr_' + id).remove();
                            $('#ajaxMessage').html('<div class="alert alert-success">Service deleted successfully.</div>');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#ajaxMessage').html('<div class="alert alert-danger">Unable to delete service.</div>');
                    }
                });
            }
        </script>
    @endpush
@endsection