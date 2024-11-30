<div class="bg-primaryWhite text-white p-4 shadow-md sticky top-0 z-40">
    <div class="mx-auto flex justify-between items-center">
        <!-- Toggle -->
        
        <div class="flex justify-start bg-[#EEF4F5] shadow-md shadow-gray-500 rounded-lg px-4 py-2 ml-5">
            <button id="toggleSidebar" class="relative h-12 w-12 flex items-center justify-center" onclick="toggleMenu()">
                <i id="menuIcon" class="fa-solid fa-bars text-4xl transition-all duration-300 text-[#096776]"></i>
                <i id="arrowIcon" class="fa-solid fa-arrow-right text-4xl transition-all duration-300 text-[#096776] opacity-0 absolute"></i>
            </button>
        </div>
       
        <!-- Profile and Menu -->
        <div class="flex items-center space-x-4">
            <!-- Profile Image -->
            <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Profile" class="w-16 h-16 rounded-full border-2 border-white" />
           
            <!-- Menu Icon -->
            <button class="text-white">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</div>

<script>
    function toggleMenu() {
        const menuIcon = document.getElementById('menuIcon');
        const arrowIcon = document.getElementById('arrowIcon');
        
        if (menuIcon.classList.contains('opacity-0')) {
            // Switch back to menu icon
            menuIcon.classList.remove('opacity-0');
            arrowIcon.classList.add('opacity-0');
        } else {
            // Switch to arrow icon
            menuIcon.classList.add('opacity-0');
            arrowIcon.classList.remove('opacity-0');
        }
    }
</script>