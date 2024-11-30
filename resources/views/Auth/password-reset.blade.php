@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="container py-5 min-h-screen flex items-center justify-center">
        <div class="p-8 rounded-lg">
            <div class="text-center mb-6">
                <h3 class="text-[48px] font-bold text-primaryText">Forgot Password?</h3>
            </div>
            <div class="p-5">
                <form action="{{ route('password.reset') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <input type="email" name="email" id="email" class="w-md p-3 py-5 mb-5 border-2 border-borderPrimary rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Email" required />
                    </div>
                    <p class="text-left text-primary">Enter your email to receive password reset instructions.  </p>

                    <button class="w-md mt-36 bg-buttonBackground text-white text-[24px] py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" type="submit">Proceed</button>

                </form>
            </div>
        </div>
    </div>
@endsection
