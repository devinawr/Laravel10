<div class="modal-header">
    <h5 class="modal-title" id="modalEditBLabel">Edit Article</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
        <label for="atitle_{{ $article->id }}" class="form-label">Title</label>
        <input type="text" class="form-control" id="atitle_{{ $article->id }}" value="{{ $article->title }}">
    </div>
    <div class="mb-3">
        <label for="acontent_{{ $article->id }}" class="form-label">Content</label>
        <textarea class="form-control" id="acontent_{{ $article->id }}" rows="4">{{ $article->content }}</textarea>
    </div>
    <div class="mb-3">
        <label for="adoctor_{{ $article->id }}" class="form-label">Doctor</label>
        <select id="adoctor_{{ $article->id }}" class="form-select">
            <option value="">-- None --</option>
            @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}" @if($article->doctor_id == $doctor->id) selected @endif>{{ $doctor->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="saveArticleDataUpdate({{ $article->id }})">Save</button>
</div>
