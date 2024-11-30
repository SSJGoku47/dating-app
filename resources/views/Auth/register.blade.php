<!-- resources/views/Auth/register.blade.php -->
@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow" style="border-radius: 1rem;">
                    <div class="card-header d-flex justify-content-center align-items-center">
                        <h3 class="mb-4">Register</h3>
                      </div>
                      <div class="card d-flex align-items-start">
                        <div class="card-body p-4">
                            <form action="/register" method="POST">
                                @csrf
                                <div class="form-group mb-3 d-flex align-items-center">
                                    <label for="name" class="me-3 mb-0">Name:</label>
                                    <input type="text" name="name" id="name" required class="form-control" placeholder="Enter name" style="flex: 1;">
                                </div>
                    
                                <div class="form-group mb-3 d-flex align-items-center">
                                    <label for="email" class="me-3 mb-0">Email:</label>
                                    <input type="email" name="email" id="email" required class="form-control" placeholder="Enter email" style="flex: 1;">
                                </div>
                    
                    
                                <div class="form-group mb-3 d-flex align-items-center">
                                    <label for="password" class="me-3 mb-0">Password:</label>
                                    <input type="password" name="password" id="password" required class="form-control" placeholder="Enter password" style="flex: 1;">
                                </div>
                    
                                <div class="form-group mb-3 d-flex align-items-center">
                                    <label for="confirm_password" class="me-3 mb-0">Confirm Password:</label>
                                    <input type="password" name="confirm_password" id="confirm_password" required class="form-control" placeholder="Confirm password" style="flex: 1;">
                                </div>
                    
                                <div class="d-flex justify-content-center mb-3 mt-5">
                                    <button class="btn btn-primary btn-lg" type="submit">Register</button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('login') }}" class="btn btn-secondary btn-md">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
