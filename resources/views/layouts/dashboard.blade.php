<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Main Wrapper -->
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <x-sidebar />
       
        <!-- Main Content Area -->
        <div id="content-area" class="flex-1 ml-72 transition-all duration-300">
            <!-- Topbar -->
            <x-topbar />
           
            <!-- Content Area -->
            <main class="p-6 overflow-y-auto h-[calc(100vh-88px)]">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const toggleSidebarButton = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const contentArea = document.getElementById('content-area');
        let isSidebarOpen = true;

        toggleSidebarButton.addEventListener('click', () => {
            isSidebarOpen = !isSidebarOpen;
           
            if (!isSidebarOpen) {
                sidebar.classList.add('-translate-x-full');
                contentArea.classList.remove('ml-72');
                contentArea.classList.add('ml-0');
            } else {
                sidebar.classList.remove('-translate-x-full');
                contentArea.classList.remove('ml-0');
                contentArea.classList.add('ml-72');
            }
        });
    </script>
</body>
</html>