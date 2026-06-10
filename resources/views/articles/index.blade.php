@extends('layouts.adminlte4')
@section('title', 'Articles Page')
@section('sidebar-article', 'active')
@section('content')
    <div class="mb-3">
        <h2>Articles Table</h2>
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
                <th>Title</th>
                <th>Content</th>
                <th>Doctor ID</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($articles as $article)
            <tr id="tr_{{ $article->id }}">
                <td>{{ $article->id }}</td>
                <td id="td_title_{{ $article->id }}">{{ $article->title }}</td>
                <td id="td_content_{{ $article->id }}">{{ $article->content }}</td>
                <td id="td_doctor_{{ $article->id }}">{{ $article->doctor_id }}</td>
                <td id="td_created_{{ $article->id }}">{{ $article->created_at }}</td>
                <td>
                    <button type="button" class="btn btn-info btn-sm" onclick="getArticleEditFormB({{ $article->id }})">
                        Edit Type B
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="if(confirm('Delete article {{ $article->title }}?')) deleteArticle({{ $article->id }})">
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
            function getArticleEditFormB(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("articles.getEditFormB") }}',
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

            function saveArticleDataUpdate(id) {
                var title = $('#atitle_' + id).val();
                var content = $('#acontent_' + id).val();
                var doctorId = $('#adoctor_' + id).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("articles.saveDataUpdate") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id,
                        'title': title,
                        'content': content,
                        'doctor_id': doctorId
                    },
                    success: function(data) {
                        if (data.status === 'oke') {
                            $('#td_title_' + id).html(title);
                            $('#td_content_' + id).html(content);
                            $('#td_doctor_' + id).html(doctorId);
                            var modalEl = document.getElementById('modalEditB');
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            modal.hide();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Error updating article');
                    }
                });
            }

            function deleteArticle(id) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("articles.deleteData") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        if (data.status === 'oke') {
                            $('#tr_' + id).remove();
                            $('#ajaxMessage').html('<div class="alert alert-success">Article deleted successfully.</div>');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        $('#ajaxMessage').html('<div class="alert alert-danger">Unable to delete article.</div>');
                    }
                });
            }
        </script>
    @endpush
@endsection