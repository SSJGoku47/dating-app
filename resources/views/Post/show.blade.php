<!-- resources/views/Post/show.blade.php -->
@extends('layouts.app')

@section('title', 'View Post')

@section('content')
<div class="container-fluid card bg-Light py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card shadow" style="border-radius: 1rem;">
                <div class="card-header d-flex justify-content-center align-items-center">
                    <h3 class="mb-4">View Post</h3>
                </div>
                <div class="card-body p-4">
                    <div class="form-group mb-3 row">
                        <label for="title" class="col-sm-4 col-form-label">Title:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ $post->title }}</p>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="content" class="col-sm-4 col-form-label">Content:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ $post->content }}</p>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="description" class="col-sm-4 col-form-label">Description:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext">{{ $post->description }}</p>
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="is_published" class="col-sm-4 col-form-label">Publish:</label>
                        <div class="col-sm-8">
                            <input type="checkbox" name="is_published" id="is_published" class="form-check-input" value="1" 
                                {{ old('is_published', $post->is_published) ? 'checked' : '' }} disabled>
                        </div>
                    </div>
                    

                    <div class="d-flex justify-content-center mt-5">
                        <a href="{{ route('post.index') }}" class="btn btn-secondary btn-md">Back to List</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
