<!-- resources/views/dashboard/dashboard.blade.php -->
@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="p-6">

    <div class="mb-20">
        <h1 class="text-primaryText text-2xl mb-4">@yield('title')</h1>
        <h2 class="text-primaryText font-medium text-3xl">Welcome, Admin!</h2>
    </div>

    <div class="grid-cols-1 flex justify-between md:grid-cols-3 gap-8">

        <!-- Total Users Card -->
        <div class="bg-white rounded-lg shadow-lg shadow-gray-400 p-6 w-md h-64 relative overflow-hidden transition-transform hover:scale-105 duration-300 border border-borderPrimary">
            <div class="flex justify-between items-start mt-10">
                <div class="ml-20 mt-5">
                    <h3 class="text-primaryText text-3xl font-semibold mb-2">Total Users</h3>
                    <p class="text-primaryText text-3xl text-center font-semibold">200</p>
                </div>
                <div class="bg-[#1e4d5f] p-2 rounded-lg mr-20 mt-5">
                    <i class="fas fa-users text-white text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="bg-white rounded-lg shadow-lg shadow-gray-400 p-6 w-md h-64 relative overflow-hidden transition-transform hover:scale-105 duration-300 border border-borderPrimary">
            <div class="flex justify-between items-start mt-10">
                <div class="ml-20 mt-5">
                    <h3 class="text-primaryText text-3xl font-semibold mb-2">Active Users</h3>
                    <p class="text-primaryText text-3xl text-center font-semibold ">150</p>
                </div>
                <div class="bg-[#1e4d5f] p-2 rounded-lg flex items-center justify-center mr-20 mt-5">
                    <i class="fas fa-user-check text-white text-3xl"></i>
                </div>
            </div>
        </div>
        

        <!-- Deactive Users Card -->
        <div class="bg-white rounded-lg shadow-lg shadow-gray-400 p-6 w-md h-64 relative overflow-hidden transition-transform hover:scale-105 duration-300 border border-borderPrimary">
            <div class="flex justify-between items-start mt-10">
                <div class="ml-20 mt-5">
                    <h3 class="text-primaryText text-3xl font-semibold mb-2">Deactive Users</h3>
                    <p class="text-primaryText text-3xl text-center font-semibold">5</p>
                </div>
                <div class="bg-[#1e4d5f] p-2 rounded-lg  mr-20 mt-5">
                    <i class="fas fa-user-minus text-white text-3xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection