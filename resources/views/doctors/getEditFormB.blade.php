<div class="modal-header">
    <h5 class="modal-title" id="modalEditBLabel">Edit Doctor</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
        <label for="dname_{{ $doctor->id }}" class="form-label">Name</label>
        <input type="text" class="form-control" id="dname_{{ $doctor->id }}" value="{{ $doctor->name }}">
    </div>
    <div class="mb-3">
        <label for="dspecialization_{{ $doctor->id }}" class="form-label">Specialization</label>
        <input type="text" class="form-control" id="dspecialization_{{ $doctor->id }}" value="{{ $doctor->specialization }}">
    </div>
    <div class="mb-3">
        <label for="demail_{{ $doctor->id }}" class="form-label">Email</label>
        <input type="email" class="form-control" id="demail_{{ $doctor->id }}" value="{{ $doctor->email }}">
    </div>
    <div class="mb-3">
        <label for="dphone_{{ $doctor->id }}" class="form-label">Phone</label>
        <input type="text" class="form-control" id="dphone_{{ $doctor->id }}" value="{{ $doctor->phone }}">
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="saveDoctorDataUpdate({{ $doctor->id }})">Save</button>
</div>
