<h3>Update Category</h3>

<div class="form-group">
    <label for="ename">Name of Category</label>

    <input type="text"
        name="name"
        class="form-control"
        id="ename"
        aria-describedby="nameHelp"
        placeholder="Enter name of category"
        value="{{ $data->category_name }}">

    <small id="nameHelp" class="form-text text-muted">
        Please write down your data here
    </small>

    <br>
</div>

<button type="button"
    onclick="saveDataUpdate({{ $data->id }})"
    class="btn btn-primary">
    Submit
</button>