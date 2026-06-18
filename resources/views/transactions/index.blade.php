@extends('layouts.adminlte4')

@section('title', 'Transaction Page')
@section('sidebar-transaction', 'active')

@section('content')
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h2>Transactions Table</h2>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Transaction
        </a>
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
                <th>User ID</th>
                <th>Doctor ID</th>
                <th>Service Type</th>
                <th>Services</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
            <tr id="tr_{{ $transaction->id }}">
                <td>{{ $transaction->id }}</td>
                <td id="td_user_{{ $transaction->id }}">{{ $transaction->user_id }}</td>
                <td id="td_doctor_{{ $transaction->id }}">{{ $transaction->doctor_id }}</td>
                <td id="td_type_{{ $transaction->id }}">{{ $transaction->service_type }}</td>
                <td>
                    <ul class="mb-0">
                        @foreach ($transaction->services as $service)
                            <li>{{ $service->service_name }} ({{ $service->pivot->qty }})</li>
                        @endforeach
                    </ul>
                </td>
                <td id="td_amount_{{ $transaction->id }}">{{ $transaction->amount }}</td>
                <td id="td_status_{{ $transaction->id }}">{{ $transaction->status }}</td>
                <td id="td_date_{{ $transaction->id }}">{{ $transaction->created_at }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-info" onclick="getTransactionEditFormB({{ $transaction->id }})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="if(confirm('Delete transaction #{{ $transaction->id }}?')) deleteTransaction({{ $transaction->id }})">
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
            function getTransactionEditFormB(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("transactions.getEditFormB") }}',
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

            function saveTransactionDataUpdate(id) {
                var userId = $('#tuser_' + id).val();
                var doctorId = $('#tdoctor_' + id).val();
                var serviceType = $('#tservice_' + id).val();
                var transactionDate = $('#tdate_' + id).val();
                var amount = $('#tamount_' + id).val();
                var status = $('#tstatus_' + id).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("transactions.saveDataUpdate") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                        'user_id': userId,
                        'doctor_id': doctorId,
                        'service_type': serviceType,
                        'transaction_date': transactionDate,
                        'amount': amount,
                        'status': status
                    },
                    success: function(data) {
                        if (data.status === 'oke') {
                            $('#td_user_' + id).html(userId);
                            $('#td_doctor_' + id).html(doctorId);
                            $('#td_type_' + id).html(serviceType);
                            $('#td_amount_' + id).html(amount);
                            $('#td_status_' + id).html(status);
                            $('#td_date_' + id).html(transactionDate);

                            var modalEl = document.getElementById('modalEditB');
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error updating transaction');
                    }
                });
            }

            function deleteTransaction(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("transactions.deleteData") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 'oke') {
                            $('#tr_' + id).remove();
                            $('#ajaxMessage').html('<div class="alert alert-success">Transaction deleted successfully.</div>');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#ajaxMessage').html('<div class="alert alert-danger">Unable to delete transaction.</div>');
                    }
                });
            }
        </script>
    @endpush
@endsection
