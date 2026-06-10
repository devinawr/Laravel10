<div class="modal-header">
    <h5 class="modal-title" id="modalEditBLabel">Edit Service</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
        <label for="sname_{{ $service->id }}" class="form-label">Service Name</label>
        <input type="text" class="form-control" id="sname_{{ $service->id }}" value="{{ $service->service_name }}">
    </div>
    <div class="mb-3">
        <label for="sdescription_{{ $service->id }}" class="form-label">Description</label>
        <textarea class="form-control" id="sdescription_{{ $service->id }}" rows="3">{{ $service->description }}</textarea>
    </div>
    <div class="mb-3">
        <label for="savailability_{{ $service->id }}" class="form-label">Availability</label>
        <input type="text" class="form-control" id="savailability_{{ $service->id }}" value="{{ $service->availability }}">
    </div>
    <div class="mb-3">
        <label for="sprice_{{ $service->id }}" class="form-label">Price</label>
        <input type="number" class="form-control" id="sprice_{{ $service->id }}" value="{{ $service->price }}">
    </div>
    <div class="mb-3">
        <label for="scategory_{{ $service->id }}" class="form-label">Category</label>
        <select id="scategory_{{ $service->id }}" class="form-select">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if($service->category_id == $category->id) selected @endif>{{ $category->category_name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="saveServiceDataUpdate({{ $service->id }})">Save</button>
</div>
