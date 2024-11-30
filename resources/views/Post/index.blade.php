@extends('layouts.app')

@section('title', 'Post Listing')

@section('content')
<div class="container-fluid card bg-Light p-5 m-2"> 
    <h1 class="mb-4">Post List</h1>

        <!-- Filter Post -->
        <form method="GET" action="{{ route('post.index') }}" class="mb-4 row g-3">
            <div class="d-flex justify-content-end align-items-center mb-3">
                <input type="checkbox" 
                       id="unpublishedToggle" 
                       name="show_unpublished" 
                       data-toggle="toggle" 
                       data-on="Unpublished" 
                       data-off="Published" 
                       data-onstyle="secondary" 
                       data-offstyle="primary" 
                       onchange="this.form.submit()"
                       {{ request('show_unpublished') ? 'checked' : '' }}>
            </div>
        </form>
    
    <!-- Post List -->
    <div class="table-responsive" id="postsContainer">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->content }}</td>
                        <td>{{ $post->description }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>
                            <a href="{{ route('post.show', $post) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('post.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('post.destroy', $post) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="d-flex justify-content-end px-5">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>

    <!-- New Post -->
    <div class="mt-4">
        <a href="{{ route('post.create') }}" class="btn btn-success">Add New Post</a>
    </div>
</div>
@endsection
