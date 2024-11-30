<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 h-full overflow-hidden">

    <!-- Main Content Area -->
    <div class="main-view flex items-center justify-center min-h-screen bg-primaryBackground relative">
        <x-toaster /> <!-- Toaster component -->

        <!-- Dynamic Content -->
        <main class="dynamic-content w-full max-w-6xl p-4 overflow-hidden">
            @yield('content') <!-- Dynamic content section -->
        </main>
    </div>
</body>
</html>
