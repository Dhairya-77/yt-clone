<?php
    $fullname='';
    $username='';
    $email='';
    $password='';
    $confirm_pw='';
    $fullname_mess = '';
    $email_mess = '';
    $user_mess='';
    $pw_err_msg = '';
    $confirm_pw_err_msg = '';

    if(isset($_POST['sign_up_btn']))
    {
        $fullname = isset($_POST['full_name']) ? $_POST['full_name'] : '';
        $username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_pw = isset($_POST['confirm_pw']) ? $_POST['confirm_pw'] : '';


        // check the emply feilds

        if (empty($_POST['full_name'])) {
            $fullname_mess = 'Enter name';  // for name
        }
        if (empty($_POST['user_name'])) {
            $user_mess = 'Enter UserName '; // User Name
        }
        if (empty($_POST['email'])) {
            $email_msg = 'Enter Valid Email';  // Email
        }
        
        if(empty($_POST['password'])){
            $pw_err_msg="Password Required";
        }elseif (strlen($password) <= 4) {
            $pw_err_msg = 'Password must be greater than 4 characters'; // password 
        }
        if (empty($_POST['confirm_pw'])) {
            $confirm_pw_err_msg = 'Confirm Password is required'; // check password
        } elseif ($password !== $confirm_pw) {
            $confirm_pw_err_msg = 'Passwords do not match'; // check password
        }
    }
        
  

?>
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
        <form action="#" method="post">
            <div class="mb-4">
                <!-- Full Name-->
                <label for="full_name" class="block text-yellow-400">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter Your Name" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400"  value="<?php echo $fullname;?>">
                <label for="full_name" class="block text-red-500 mb-2"><?php echo $fullname_mess; ?></label>
            </div>

            <div class="mb-4">
                 <!-- User Name-->
                <label for="user_name" class="block text-yellow-400">Username</label>
                <input type="text" id="user_name" name="user_name" placeholder="Enter Your Username" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" value="<?php echo $username;?>">
                <label for="user_name" class="block text-red-500 mb-2"><?php echo $user_mess; ?></label>
            </div>

            <div class="mb-4">
                <!-- Email-->
                <label for="email" class="block text-yellow-400">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" value="<?php echo $email;?>">
                <label for="email" class="block text-red-500 mb-2"><?php echo $email_msg; ?></label>
            </div>

            <!-- Password-->
            <div class="mb-4">
                <label for="password" class="block text-yellow-400">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Your Password" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" value="<?php echo $password;?>">
                <label for="password" class="block text-red-500 mb-2"><?php echo $pw_err_msg; ?></label>
            </div>

<!-- COnfirm Password-->
            <div class="mb-6">
                <label for="confirm_pw" class="block text-yellow-400">Confirm Password</label>
                <input type="password" id="confirm_pw" name="confirm_pw" placeholder="Confirm Your Password" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" value="<?php echo $password;?>">
                <label for="confirm_pw" class="block text-red-500 mb-2"><?php echo $confirm_pw_err_msg; ?></label>
            </div>

            <!-- Button -->
            <button type="submit" name="sign_up_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">Submit</button>
        </form>
    </div>
</body>
</html>
