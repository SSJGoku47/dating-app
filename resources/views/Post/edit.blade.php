<!-- resources/views/Post/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Post')

@section('content')
<div class="container-fluid card bg-Light py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card shadow" style="border-radius: 1rem;">
                <div class="card-header d-flex justify-content-center align-items-center">
                    <h3 class="mb-4">Edit Post</h3>
                </div>
                <div class="card-body p-4">
                    <!-- Errors Toaster -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Edit Product Form -->
                    <form action="{{ route('post.update', $post) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3 row">
                            <label for="title" class="col-sm-4 col-form-label">Post Name:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="content" class="col-sm-4 col-form-label">Content:</label>
                            <div class="col-sm-8">
                                <textarea name="content" id="content" required class="form-control" placeholder="Enter Content">{{ old('content',$post->content) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="description" class="col-sm-4 col-form-label">Description:</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $post->description) }}</textarea>
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <label for="is_published" class="col-sm-4 col-form-label">Publish:</label>
                            <div class="col-sm-8">
                                <input type="checkbox" name="is_published" id="is_published" class="form-check-input" value="1" 
                                    {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mb-3 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg">Update Post</button>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('post.index') }}" class="btn btn-secondary btn-md">Back to List</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
