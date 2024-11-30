<!-- resources/views/components/toaster.blade.php -->
<div class="fixed top-[95px] right-[189px] z-100 flex justify-center mt-5 mr-5">
    @if (session('success')) <!-- Success -->
        <div class="toaster bg-green-600 text-white rounded-lg p-6 mb-4 w-80 shadow-lg flex items-center space-x-3">
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <div class="flex-1 text-center">
                {{ session('success') }}
            </div>
            <button type="button" class="text-white ml-3" onclick="this.parentElement.style.display='none'">
                &times;
            </button>
        </div>
    @endif

    @if (session('error')) <!-- Error -->
        <div class="toaster bg-red-600 text-white rounded-lg p-6 mb-4 w-80 shadow-lg flex items-center space-x-3">
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            <div class="flex-1 text-center">
                {{ session('error') }}
            </div>
            <button type="button" class="text-white ml-3" onclick="this.parentElement.style.display='none'">
                &times;
            </button>
        </div>
    @endif
</div>

<script>
    // Automatically hide the toaster after a while
    setTimeout(function() {
        let toaster = document.querySelector('.toaster');
        if (toaster) {
            toaster.style.display = 'none';
        }
    }, 5000); // 5 seconds timeout
</script>
