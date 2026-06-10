@extends('layouts.adminlte4')
@section('title', 'Category Page')
@section('sidebar-category', 'active')
@section('content')

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>
<h2>List of Categories</h2>
<p>
    The <a href="#" onclick="showInfo()">.table</a> class adds basic styling
    (light padding and only horizontal dividers) to a table:
</p>
<div id="showInfo"></div>
<div id="ajaxMessage"></div>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if (session('status'))
    <div class="alert alert-warning">
        {{ session('status') }}
    </div>
@endif
<a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
    + New Category
</a>
<button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#btnFormModal">
    + New Category (with Modals)
</button>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Images</th>
            <th>Category Name</th>
            <th>Number Of Services</th>
            <th>Services</th>
            <th>Detail</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $c)
            <tr id="tr_{{ $c->id }}">
                <td>{{ $c->id }}</td>

                <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#imageModal-{{ $c->id }}">
                        Show
                    </button>
                </td>

                <td id="td_name_{{ $c->id }}">
                    {{ $c->category_name }}
                </td>

                <td>{{ $c->services->count() }}</td>

                <td>
                    <ul>
                        @foreach ($c->services as $s)
                            <li>{{ $s->service_name }}</li>
                        @endforeach
                    </ul>
                </td>

                <td>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                        data-bs-target="#detailModal" onclick="showDetail({{ $c->id }})">
                        Details
                    </button>
                </td>

                <td>
                    <a class="btn btn-warning" href="{{ route('categories.edit', $c->id) }}">
                        Edit
                    </a>

                    <a href="#modalEditA" class="btn btn-warning" data-bs-toggle="modal"
                        onclick="getEditForm({{ $c->id }})">
                        Edit Type A
                    </a>

                    <button type="button"
                        class="btn btn-info"
                        onclick="getEditFormB({{ $c->id }})">
                        Edit Type B
                    </button>
                    @can('delete-permission', Auth::user())
                     <a href="#"
    class="btn btn-danger"
    onclick="if(confirm('Are you sure to delete {{ $c->id }} - {{ $c->category_name }} ?')) deleteDataRemove({{ $c->id }});">
    Delete without Reload
</a>
@endcan

                    <form method="POST" action="{{ route('categories.destroy', $c->id) }}" style="display: inline-block;">
                        @csrf
                        @method('DELETE')

                        <input type="submit"
                            value="Delete"
                            class="btn btn-danger"
                            onclick="return confirm('Are you sure to delete {{ $c->id }} - {{ $c->category_name }}?');">
                    </form>
                </td>
            </tr>

            @push('modal')
                <div class="modal fade" id="imageModal-{{ $c->id }}" tabindex="-1"
                    aria-labelledby="imageModalLabel-{{ $c->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="imageModalLabel-{{ $c->id }}">
                                    Gambar untuk Kategori {{ $c->id }}
                                </h1>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <p>{{ $c->id }} - {{ $c->category_name }}</p>

                                <img src="{{ asset('storage/' . $c->image) }}"
                                    alt="Category Image"
                                    class="img-fluid">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @endpush
        @endforeach
    </tbody>
</table>

@push('modal')
    <div class="modal fade" id="btnFormModal" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Add New Category</h4>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="{{ route('categories.store') }}">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name of Category</label>

                            <input type="text"
                                name="name"
                                class="form-control"
                                id="name"
                                aria-describedby="nameHelp"
                                placeholder="Enter name of category">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endpush

@push('modal')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Modal title
                    </h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    ...
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="button" class="btn btn-primary">
                        Save changes
                    </button>
                </div>

            </div>
        </div>
    </div>
@endpush

@push('modal')
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detail-title">
                        List of
                    </h1>

                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body" id="detail-body">
                    ...
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
@endpush

@push('modal')
    <div class="modal fade" id="modalEditA" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Edit Your Category</h4>
                </div>

                <div class="modal-body">
                    <div id="modalContent">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endpush

@push('modal')
    <div class="modal fade" id="modalEditB" tabindex="-1" aria-labelledby="modalEditBLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modalContentB">

            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        function deleteDataRemove(id) {
    $.ajax({
        type: 'POST',
        url: '{{ route("categories.deleteData") }}',
        data: {
            '_token': '{{ csrf_token() }}',
            'id': id
        },
        success: function(data) {
            if (data.status == "oke") {
                $('#tr_' + id).remove();

                $('#ajaxMessage').html(
                    '<div class="alert alert-success">Have successfully deleted the category.</div>'
                );
            } else {
                $('#ajaxMessage').html(
                    '<div class="alert alert-warning">' + data.msg + '</div>'
                );
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);

            $('#ajaxMessage').html(
                '<div class="alert alert-danger">Failed to delete data. Please check related data first.</div>'
            );
        }
    });
}

        function showInfo() {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.showInfo") }}',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#showInfo').html(data.msg);
                }
            });
        }

        function showDetail(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.showListServices") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'idcat': id
                },
                success: function(data) {
                    $('#detail-title').html(data.title);
                    $('#detail-body').html(data.body);
                }
            });
        }

        function getEditForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("categories.getEditForm") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id
                },
                success: function(data) {
                    $('#modalContent').html(data.msg);
                }
            });
        }

        function getEditFormB(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("categories.getEditFormB") }}',
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
                    alert('Error mengambil form Edit Type B');
                }
            });
        }

        function saveDataUpdate(id) {
    var name = $('#ename_' + id).val();

    console.log('ID:', id);
    console.log('Name:', name);

    $.ajax({
        type: 'POST',
        url: '{{ route("categories.saveDataUpdate") }}',
        data: {
            '_token': '{{ csrf_token() }}',
            'id': id,
            'name': name
        },
        success: function(data) {
            if (data.status == "oke") {
                $('#td_name_' + id).html(name);

                var modalEl = document.getElementById('modalEditB');
                var modal = bootstrap.Modal.getInstance(modalEl);
                modal.hide();
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
            alert('Error update data');
        }
    });
}
    </script>
@endpush

@endsection