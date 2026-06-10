<div class="modal-header">
    <h5 class="modal-title" id="modalEditBLabel">Edit Transaction</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
        <label for="tuser_{{ $transaction->id }}" class="form-label">User</label>
        <select id="tuser_{{ $transaction->id }}" class="form-select">
            @foreach ($users as $user)
                <option value="{{ $user->id }}" @if($transaction->user_id == $user->id) selected @endif>{{ $user->name ?? $user->email }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="tdoctor_{{ $transaction->id }}" class="form-label">Doctor</label>
        <select id="tdoctor_{{ $transaction->id }}" class="form-select">
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" @if($transaction->doctor_id == $doctor->id) selected @endif>{{ $doctor->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="tservice_{{ $transaction->id }}" class="form-label">Service Type</label>
        <input type="text" class="form-control" id="tservice_{{ $transaction->id }}" value="{{ $transaction->service_type }}">
    </div>
    <div class="mb-3">
        <label for="tdate_{{ $transaction->id }}" class="form-label">Transaction Date</label>
        <input type="datetime-local" class="form-control" id="tdate_{{ $transaction->id }}" value="{{ $transaction->transaction_date->format('Y-m-d\TH:i') }}">
    </div>
    <div class="mb-3">
        <label for="tamount_{{ $transaction->id }}" class="form-label">Amount</label>
        <input type="number" class="form-control" id="tamount_{{ $transaction->id }}" value="{{ $transaction->amount }}" step="0.01">
    </div>
    <div class="mb-3">
        <label for="tstatus_{{ $transaction->id }}" class="form-label">Status</label>
        <select id="tstatus_{{ $transaction->id }}" class="form-select">
            <option value="pending" @if($transaction->status == 'pending') selected @endif>Pending</option>
            <option value="completed" @if($transaction->status == 'completed') selected @endif>Completed</option>
            <option value="cancelled" @if($transaction->status == 'cancelled') selected @endif>Cancelled</option>
        </select>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="saveTransactionDataUpdate({{ $transaction->id }})">Save</button>
</div>
