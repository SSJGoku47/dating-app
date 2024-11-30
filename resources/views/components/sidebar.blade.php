<aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 transform transition-transform duration-300 ease-in-out">
    <div class="w-72 bg-buttonBackground text-white h-full">
        
        <!-- Logo Section -->
        <div class="p-4 flex flex-col items-center">
            <h4 class="mt-2 text-lg font-semibold">Logo</h4>
        </div>
        <!-- Profile Section -->
        <div class="p-4 flex flex-col items-center">
            <img src="https://via.placeholder.com/100" alt="User Profile" class="rounded-full">
            <h4 class="mt-2">{{ Auth::user()->name }}</h4>
        </div>

        <!-- Sidebar Links -->
        <ul class="grid text-lg justify-center p-4 space-y-4 mt-5">
            <li class="flex items-center space-x-2 pb-7">
                <i class="fas fa-home mr-4"></i>
                <a href="{{ route('dashboard') }}" class="text-white hover:underline">Dashboard</a>
            </li>
            <li class="flex items-center space-x-2 pb-7">
                <i class="fas fa-users mr-4"></i>
                <a href="#" class="text-white hover:underline">User Management</a>
            </li>
            <li class="flex items-center space-x-2 pb-7">
                <i class="fas fa-question-circle mr-4"></i>
                <a href="#" class="text-white hover:underline">Questions</a>
            </li>
            <li class="flex items-center space-x-2">
                <i class="fas fa-sign-out-alt mr-4"></i>
                <form action="{{ route('logout') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="text-white text-left hover:underline">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>