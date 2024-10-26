<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-950 flex items-center justify-center min-h-screen">
    <div class="bg-purple-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <!-- Profile Form -->
        <h2 class="text-yellow-400 font-semibold text-center text-3xl mb-6">Profile</h2>
        <form action="#" method="POST" enctype="multipart/form-data">
            <!-- Profile Image Upload -->
            <div class="flex items-center justify-center mb-6">
                <label for="profileImage" class="relative cursor-pointer">
                    <img src="req_img/profile_icon.png" id="profileImagePreview" alt="Profile Image" class="w-24 h-24 rounded-full border-4 border-yellow-400 object-cover">
                </label>
                <input type="file" id="profileImage" name="profile_image" accept="image/*" class="hidden">
            </div>

            <!-- Profile Form Fields (same as registration) -->
            <div class="mb-4">
                <label for="full_name" class="block text-yellow-400">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter Your Name" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="mb-4">
                <label for="user_name" class="block text-yellow-400">Username</label>
                <input type="text" id="user_name" name="user_name" placeholder="Enter Your Username" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="mb-6">
                <label for="email" class="block text-yellow-400">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="email" class="block text-red-400"></label>
            </div>

            <!-- Save Changes Button -->
            <button type="submit" name="save_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">Save Changes</button>
        </form>
    </div>

    <script>
        // JavaScript to preview uploaded profile image
        const profileImageInput = document.getElementById('profileImage');
        const profileImagePreview = document.getElementById('profileImagePreview');

        profileImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
