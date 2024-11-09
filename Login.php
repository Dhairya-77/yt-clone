<?php
    $email_err_msg='';
    $pw_err_msg='';
    $email='';
    
    if(isset($_POST['login_btn'])){
        $email=isset($_POST['email']) ? $_POST['email'] : '';
        if(empty($_POST['email'])){
            $email_err_msg='Enter Email';
        }
        if(empty($_POST['password'])){
            $pw_err_msg='Enter Password';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-950 min-h-screen flex items-center justify-center">
    <div class="bg-purple-800 rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-3xl font-bold text-center text-yellow-400 mb-6">Login</h2>
        <form method="post">
        <div class="mb-4">
                <label for="username" class="block text-yellow-400 mb-2">Email</label>
                <input type="text" id="username" name="username" value="<?php echo $username;?>" class="w-full px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" placeholder="Enter your Username">
                <label for="username" name="username_err_text" class="block text-red-500 mb-2"> <?php echo $username_err_msg; ?> </label>
            </div>
            <div class="mb-6">
                <label for="password" class="block text-yellow-400 mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" placeholder="Enter your password">
                <label for="password" name="pw_err_text" class="block text-red-500 mb-2"> <?php echo $pw_err_msg; ?> </label>
            </div>
            <div class="mb-8"> <!-- Forgot Password -->
            <a href="ForgotPassword.php" name="sign_up_text" id="sign_up_text "class="text-yellow-400 underline hover:text-yellow-300">Forgot Password</a>
            </div>
            <button type="submit" name="login_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">Login</button>
        </form>
        <p class="text-yellow-300 mt-6 text-center">Don't have an account? <a href="Sign_Up.p" name="sign_up_text" class="text-yellow-400 underline hover:text-yellow-300">Sign up</a></p>
    </div>
</body>
</html>