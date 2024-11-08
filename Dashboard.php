<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-950 text-yellow-400">

    <!-- Header -->
    <header class="flex items-center justify-between p-4 bg-purple-800 shadow-lg">
        <!-- App Logo and Name -->
        <div class="flex items-center">
            <img src="req_img//logo.png" title="VTubes" alt="App Logo" class="h-10 w-10 mr-3">
            <h1 class="text-xl font-bold">VTube</h1>
        </div>

        <!-- Search Bar -->
        <div class="flex-1 max-w-lg mx-4">
            <form action="Dashboard.php?page=Search_Result" method="post">
                <input type="text" name="search_str" placeholder="Search..." class="w-full p-2 rounded bg-purple-700 text-yellow-400 rounded-md border-2 border-yellow-500 focus:outline-none focus:border-yellow-300">
            </form>
        </div>

        <!-- Right Side: Upload Image and Profile Image -->
        <div class="flex items-center space-x-4">
            <!-- Upload Button -->
            <a href="Upload_Video.php?uid=1">
                <button name="upl_btn" title="Upload Video" class="flex items-center justify-center w-10 h-10 bg-yellow-400 text-purple-900 rounded-full hover:bg-yellow-400">
                <img src="req_img//upload_icon.png" alt="Upload" class="w-5 h-5">
                </button>
            </a>

            <!-- Profile Image -->
            <div class="relative">
                <img src="req_img//profile_icon.png" id="profile_btn" name="profile_btn" alt="Profile" class="h-10 w-10 rounded-full cursor-pointer">

                <!-- Dropdown Menu -->
                <div id="profile_menu" name="profile_menu" class="hidden absolute right-0 mt-2 w-48 bg-purple-800 border border-yellow-500 shadow-lg rounded-lg overflow-hidden">
                    <a href="Profile.php?uid=null" name="profile_menu_btn" class="flex items-center px-4 py-2 hover:bg-purple-700">
                        <img src="req_img//profile_icon.png" alt="Profile" class="w-5 h-5 mr-2">Profile
                    </a>
                    <a href="#" name="logout_menu_btn" class="flex items-center px-4 py-2 hover:bg-purple-700">
                        <img src="req_img//logout_icon.png" alt="Logout" class="w-5 h-5 mr-2">Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Separation Line -->
    <div class="border-b border-yellow-500"></div>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-40 flex-shrink-0 bg-purple-800 p-4">
            <nav class="flex flex-col space-y-4">
                <a href="Dashboard.php?page=Home" name="home" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//home_icon.png" alt="Home" class="w-5 h-5">
                    <span>Home</span>
                </a>
                <a href="Dashboard.php?page=Recent_Watched" name="recent_watched" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//recent_icon.png" alt="Recent Watched" class="w-5 h-5">
                    <span>Recent Watched</span>
                </a>
                <a href="Dashboard.php?page=Saved_Videos" name="saved_videos" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//bookmark_icon.png" alt="Saved Videos" class="w-5 h-5">
                    <span>Saved Videos</span>
                </a>
                <a href="Dashboard.php?page=Subscribed_Channels" name="subscribed_channels" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//subscribe_icon.png" alt="Subscribed Channels" class="w-5 h-5">
                    <span>Subscribed Channels</span>
                </a>
                <a href="Dashboard.php?page=Your_Videos" name="your_videos" class="flex items-center space-x-3 hover:bg-purple-700 p-2 rounded">
                    <img src="req_img//video_icon.png" alt="Your Videos" class="w-5 h-5">
                    <span>Your Videos</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <?php
                // Get the 'page' parameter from the URL
                $page = isset($_GET['page']) ? $_GET['page'] : 'Home';

                // Construct file path
                $file = $page . '.php';

                // Check if the file exists and include it
                if (file_exists($file)) {
                    include($file);
                }
            ?>
        </main>
    </div>
</body>
<script>
        // Toggle profile dropdown
        const profileBtn = document.getElementById('profile_btn');
        const profileMenu = document.getElementById('profile_menu');
        
        profileBtn.addEventListener('click', () => {
            profileMenu.classList.toggle('hidden');
        });
</script>
</html>