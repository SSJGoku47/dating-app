<!-- resources/views/Post/create.blade.php -->
@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <div class="container-fluid card bg-Light py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card shadow" style="border-radius: 1rem;">
                    <div class="card-header d-flex justify-content-center align-items-center">
                        <h3 class="mb-4">Create Post</h3>
                    </div>
                    <div class="card-body p-4">

                        <!-- Create Post Form -->
                        <form action="{{ route('post.store') }}" method="POST">
                            @csrf

                            <div class="form-group mb-3 row">
                                <label for="title" class="col-sm-4 col-form-label">Title:</label>
                                <div class="col-sm-8">
                                    <input type="text" name="title" id="title" required class="form-control" value="{{ old('title') }}" placeholder="Enter Title">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="content" class="col-sm-4 col-form-label">Content:</label>
                                <div class="col-sm-8">
                                    <textarea name="content" id="content" required class="form-control" placeholder="Enter Content">{{ old('content') }}</textarea>
                                </div>
                            </div>
                            
                            <div class="form-group mb-3 row">
                                <label for="description" class="col-sm-4 col-form-label">Description:</label>
                                <div class="col-sm-8">
                                    <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label for="is_published" class="col-sm-4 col-form-label">Publish:</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" name="is_published" id="is_published" class="form-check-input" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                </div>
                            </div>
                            

                            <div class="d-flex justify-content-center mb-3 mt-5">
                                <button class="btn btn-primary btn-lg" type="submit">Create Post</button>
                            </div>

                        </form>

                        <div class="d-flex justify-content-center">
                            <a href="{{ route('post.index') }}" class="btn btn-secondary btn-md">Back to List</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
