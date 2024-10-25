<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind Configration -->
</head>
<body class="bg-violet-900 flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <!-- Registration Form -->
        <fieldset>
            <legend class="text-violet-900 font-semibold text-center text-xl">Registration Form</legend>
            <form action="#">
                <label for="Name" class="text-violet-900">Full Name</label>
                <input type="text" id="Name" name="Name" required placeholder="Enter Your Name" class="h-10 w-full mt-2 border-2 text-yellow-400 rounded-md border-yellow-400 border-solid p-2">

                <label for="uName" class="text-violet-900 mt-4">Username</label>
                <input type="text" id="uName" name="uName" required placeholder="Enter Your Username" class="h-10 w-full mt-2 border-2 text-yellow-400 rounded-md border-yellow-400 border-solid p-2"><br>

                <label for="Uemail" class="text-violet-900 mt-4">Email</label>
                <input type="email" id="Uemail" name="Uemail" required placeholder="Enter Your Email" class="h-10 w-full mt-2 border-2 text-yellow-400 rounded-md border-yellow-400 border-solid p-2"><br>

                <label for="Upassword" class="text-violet-900 mt-4">Password</label>
                <input type="password" id="Upassword" name="Upassword" required placeholder="Enter Your Password" class="h-10 w-full mt-2 border-2 text-yellow-400 rounded-md border-yellow-400 border-solid p-2"> 

                <label for="UCpassword" class="text-violet-900 mt-4">Confirm Password</label>
                <input type="password" id="UCpassword" name="UCpassword" required placeholder="Confirm Your Password" class="h-10 w-full mt-2 border-2 text-yellow-400 rounded-md border-yellow-400 border-solid p-2"><br>

                <!-- Button -->
                <input type="button" value="Submit" class="bg-yellow-400 hover:bg-yellow-500 text-violet-900 h-10 w-full mt-4 rounded-md text-xl">
            </form>
        </fieldset>
    </div>
</body>
</html>
