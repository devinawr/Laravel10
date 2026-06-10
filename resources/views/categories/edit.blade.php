@extends('layouts.adminlte4')
@section('title', 'Edit Category')
@section('sidebar-category', 'active')
@section('content')

<div class="container">
    <h2>Edit Category</h2>
    <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text"
                class="form-control"
                id="name"
                name="categoryName"
                aria-describedby="name"
                placeholder="Enter Category Name"
                value="{{ old('categoryName', $category->category_name) }}">
            <small id="name" class="form-text text-muted">
                Please write down Category Name here.
            </small>
            @error('categoryName')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="image">Category Image</label>
            @if ($category->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $category->image) }}"
                        alt="Category Image"
                        width="150"
                        class="img-thumbnail">
                </div>
            @endif
            <input type="file"
                class="form-control"
                id="image"
                name="image">
            @error('image')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            Submit
        </button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Back
        </a>
    </form>
</div>
@endsection