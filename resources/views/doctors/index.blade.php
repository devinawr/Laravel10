@extends('layouts.adminlte4')
@section('title', 'Doctors Page')
@section('sidebar-doctor', 'active')
@section('content')
    <div class="mb-3">
        <h2>Doctors Table</h2>
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
                <th>Name</th>
                <th>Specialization</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($doctors as $doctor)
            <tr id="tr_{{ $doctor->id }}">
                <td>{{ $doctor->id }}</td>
                <td id="td_name_{{ $doctor->id }}">{{ $doctor->name }}</td>
                <td id="td_specialization_{{ $doctor->id }}">{{ $doctor->specialization }}</td>
                <td id="td_email_{{ $doctor->id }}">{{ $doctor->email }}</td>
                <td id="td_phone_{{ $doctor->id }}">{{ $doctor->phone }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" onclick="getDoctorEditFormB({{ $doctor->id }})">
                        Edit Type B
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Delete doctor {{ $doctor->name }}?')) deleteDoctor({{ $doctor->id }})">
                        Delete
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
            function getDoctorEditFormB(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("doctors.getEditFormB") }}',
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

            function saveDoctorDataUpdate(id) {
                var name = $('#dname_' + id).val();
                var specialization = $('#dspecialization_' + id).val();
                var email = $('#demail_' + id).val();
                var phone = $('#dphone_' + id).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("doctors.saveDataUpdate") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                        'name': name,
                        'specialization': specialization,
                        'email': email,
                        'phone': phone
                    },
                    success: function(data) {
                        if (data.status === 'oke') {
                            $('#td_name_' + id).html(name);
                            $('#td_specialization_' + id).html(specialization);
                            $('#td_email_' + id).html(email);
                            $('#td_phone_' + id).html(phone);
                            var modalEl = document.getElementById('modalEditB');
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error updating doctor');
                    }
                });
            }

            function deleteDoctor(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("doctors.deleteData") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 'oke') {
                            $('#tr_' + id).remove();
                            $('#ajaxMessage').html('<div class="alert alert-success">Doctor deleted successfully.</div>');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#ajaxMessage').html('<div class="alert alert-danger">Unable to delete doctor.</div>');
                    }
                });
            }
        </script>
    @endpush
@endsection