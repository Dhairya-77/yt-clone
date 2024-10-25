<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind Configuration -->
</head>
<body class="bg-violet-900 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <!-- Forgot Password Form -->
        <fieldset>
            <legend class="text-violet-900 font-semibold text-center text-xl">Forgot Password</legend>
            <form action="#">
                <label for="username" class="text-violet-900">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter Your Username" class="h-10 w-full mt-2 border-2 text-yellow-400 rounded-md border-yellow-400 border-solid p-2">

                <label for="newPassword" class="text-violet-900 mt-4">New Password</label>
                <input type="password" id="newPassword" name="newPassword" required placeholder="Enter Your New Password" class="h-10 w-full mt-2 border-2 text-yellow-400 rounded-md border-yellow-400 border-solid p-2"> 

                <label for="confirmPassword" class="text-violet-900 mt-4">Confirm New Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required placeholder="Confirm Your New Password" class="h-10 w-full mt-2 border-2 text-yellow-400 rounded-md border-yellow-400 border-solid p-2"><br>

                <!-- Button -->
                <input type="button" value="Reset Password" class="bg-yellow-400 hover:bg-yellow-500 text-violet-900 h-10 w-full mt-4 rounded-md text-xl">
            </form>
        </fieldset>
    </div>
</body>
</html>
