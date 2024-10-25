<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind Configuration -->
</head>
<body class="bg-purple-950 flex items-center justify-center min-h-screen">
    <div class="bg-purple-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <!-- Registration Form -->
        <h2 class="text-yellow-400 font-semibold text-center text-3xl mb-6">Registration Form</h2>
        <form action="#">
            <div class="mb-4">
                <label for="full_name" class="block text-yellow-400">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter Your Name" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="mb-4">
                <label for="user_name" class="block text-yellow-400">Username</label>
                <input type="text" id="user_name" name="user_name" placeholder="Enter Your Username" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-yellow-400">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-yellow-400">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <div class="mb-6">
                <label for="confirm_pw" class="block text-yellow-400">Confirm Password</label>
                <input type="password" id="confirm_pw" name="confirm_pw" placeholder="Confirm Your Password" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
            </div>

            <!-- Button -->
            <button type="submit" name="sign_up_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">Submit</button>
        </form>
    </div>
</body>
</html>
