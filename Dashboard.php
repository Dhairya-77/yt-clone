<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        // Toggle profile dropdown
        const profileBtn = document.getElementById('profileBtn');
        const profileMenu = document.getElementById('profileMenu');
        
        profileBtn.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });
    </script>
</head>
<body class="bg-purple-900 text-yellow-400">

    <!-- Header -->
    <header class="flex items-center justify-between p-4 bg-purple-800 shadow-lg">
        <!-- App Logo and Name -->
        <div class="flex items-center">
            <img src="req_img//logo.png" alt="App Logo" class="h-10 w-10 mr-3">
            <h1 class="text-xl font-bold">VTubes</h1>
        </div>

        <!-- Search Bar -->
        <div class="flex-1 max-w-lg mx-4">
            <input type="text" placeholder="Search..." class="w-full p-2 rounded bg-purple-700 text-yellow-400 border-2 border-yellow-500 focus:outline-none focus:border-yellow-300">
        </div>

        <!-- Right Side: Upload Image and Profile Image -->
        <div class="flex items-center space-x-4">
            <!-- Upload Button -->
            <button class="flex items-center justify-center w-10 h-10 bg-yellow-400 text-purple-900 rounded-full hover:bg-yellow-400">
                <img src="req_img//upload_icon.png" alt="Upload" class="w-5 h-5">
            </button>

            <!-- Profile Image -->
            <div class="relative">
                <img src="profile_img//new d7 crop.jpg" alt="Profile" class="h-10 w-10 rounded-full cursor-pointer" id="profileBtn">

                <!-- Dropdown Menu -->
                <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-purple-800 border border-yellow-500 shadow-lg rounded-lg overflow-hidden">
                    <a href="#" class="flex items-center px-4 py-2 hover:bg-purple-700">
                        <img src="req_img//profile_icon.png" alt="Profile" class="w-5 h-5 mr-2">Profile
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 hover:bg-purple-700">
                        <img src="req_img//logout_icon.png" alt="Logout" class="w-5 h-5 mr-2">Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="border-b border-yellow-500"></div>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 h-screen bg-purple-800 p-4">
            <nav class="flex flex-col space-y-4">
                <a href="#" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//home_icon.png" alt="Home" class="w-5 h-5"><span>Home</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//recent_icon.png" alt="Recent Watched" class="w-5 h-5"><span>Recent Watched</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//bookmark_icon.png" alt="Saved Videos" class="w-5 h-5"><span>Saved Videos</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//subscribe_icon.png" alt="Subscribed Channels" class="w-5 h-5"><span>Subscribed Channels</span>
                </a>
                <a href="#" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//video_icon.png" alt="Your Videos" class="w-5 h-5"><span>Your Videos</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <h2 class="text-3xl font-bold">Dashboard Content</h2>
            <!-- Add more content here -->
        </main>
    </div>
</body>
</html>
