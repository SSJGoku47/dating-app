@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container py-5 min-h-screen flex items-center justify-center">
        <div class="p-8 rounded-lg">
            <div class="text-center mb-6">
                <h3 class="text-[48px] font-bold text-primaryText">Login</h3>
            </div>
            <div class="p-5">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <input type="email" name="email" id="email" class="w-md text-lg p-3 py-5 mb-5 border-2 border-borderPrimary rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Email" required />
                    </div>

                    <div class="mb-4">
                        <input type="password" name="password" id="password" class="w-md text-lg p-3 py-5 mb-5 border-2 border-borderPrimary rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Password" required />
                    </div>

                    <div class="flex justify-end items-center mb-5">
                        <a href="{{ route('password.reset') }}" class="font-normal text-[20px] text-primaryBlack">Forgot Password?</a>
                    </div>

                    <button class="w-md bg-buttonBackground text-white text-[24px] py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
@endsection
