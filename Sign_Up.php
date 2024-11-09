<?php
    require_once "db_code.php";

    session_start();

    $db_obj=new DB();

    $fullname='';
    $username='';
    $email='';
    $password='';
    $confirm_pw='';

    $fullname_err_msg = '';
    $email_err_msg = '';
    $username_err_msg='';
    $pw_err_msg = '';
    $confirm_pw_err_msg = '';

    if(isset($_POST['sign_up_btn']))
    {
        $fullname = isset($_POST['full_name']) ? $_POST['full_name'] : '';
        $username = isset($_POST['user_name']) ? $_POST['user_name'] : '';
        $email = isset($_POST['user_name']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $confirm_pw = isset($_POST['confirm_pw']) ? $_POST['confirm_pw'] : '';

        // check the emply feilds
        if(empty($_POST['full_name']) || empty($_POST['user_name']) || empty($_POST['email']) 
            || empty($_POST['password']) || empty($_POST['confirm_pw']))
        {
            
            if(empty($_POST['full_name'])){
                $fullname_err_msg='Enter Full Name';
            }

            if(empty($_POST['user_name'])){
                $username_err_msg='Enter UserName ';
            }

            if(empty($_POST['email'])){
                $email_err_msg='Enter Email';
            }

            if(empty($_POST['password'])){
                $pw_err_msg='Enter Password';
            }

            if(empty($_POST['confirm_pw'])){
                $confirm_pw_err_msg='Enter Confirm Password';
            }
        }
        else if($con_obj->isUserPresent($_POST['user_name'])){
            $username_err='UserName is aleady exist';
        }
        else if(!preg_match('/^[a-zA-Z0-9.]+@[a-zA-Z.]+\.[a-zA-Z]{2,}$/',$_POST['email'])){
            $email_err_msg='Enter mail in proper format';
        }
        else if (strlen($password) <= 4) {
            $pw_err_msg = 'Password must be greater than 4 characters'; // password 
        }
        elseif (strcmp($_POST['password'],$_POST['confirm_pw'])!==0) {
            $confirm_pw_err_msg = 'Not Match'; // check password
        }
        else{

            $db_obj->insertUser($_POST['full_name'],$_POST['user_name'],$_POST['email'],$_POST['password']);
            $_SESSION['un']=$_POST['user_name'];
            $_SESSION['pw']=$_POST['password'];
            $_SESSION['uid'] = $db_obj->getUid($_POST['user_name'] ,$_POST['password']);

            setcookie("un",$_SESSION['un'],time()+3600,"/");
            setcookie("pw",$_SESSION['pw'],time()+3600,"/");
            setcookie("uid",$_SESSION['uid'],time()+3600,"/");
                
            header('location: Dashboard.php');
            exit;
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
        <h2 class="text-yellow-400 font-semibold text-center text-3xl mb-6">Sign Up</h2>
        <form method="post">
            <div class="mb-4">
                <!-- Full Name-->
                <label for="full_name" class="block text-yellow-400">Full Name(First name & Last Name)</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo $fullname;?>" placeholder="Enter Your Name" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400"  value="<?php echo $fullname;?>">
                <label for="full_name" class="block text-red-500 mb-2"><?php echo $fullname_err_msg; ?></label>
            </div>

            <div class="mb-4">
                 <!-- User Name-->
                <label for="user_name" class="block text-yellow-400">Username</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo $username;?>" placeholder="Enter Your Username" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" value="<?php echo $username;?>">
                <label for="user_name" class="block text-red-500 mb-2"><?php echo $username_err_msg; ?></label>
            </div>

            <div class="mb-4">
                <!-- Email-->
                <label for="email" class="block text-yellow-400">Email</label>
                <input type="email" id="email" name="email" value="<?php echo $email;?>" placeholder="Enter Your Email" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" value="<?php echo $email;?>">
                <label for="email" class="block text-red-500 mb-2"><?php echo $email_err_msg; ?></label>
            </div>

            <!-- Password-->
            <div class="mb-4">
                <label for="password" class="block text-yellow-400">Password</label>
                <input type="password" id="password" name="password" value="<?php echo $password;?>" placeholder="Enter Your Password" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" value="<?php echo $password;?>">
                <label for="password" class="block text-red-500 mb-2"><?php echo $pw_err_msg; ?></label>
            </div>

            <!-- Confirm Password-->
            <div class="mb-6">
                <label for="confirm_pw" class="block text-yellow-400">Confirm Password</label>
                <input type="password" id="confirm_pw" name="confirm_pw" value="<?php echo $confirm_pw;?>" placeholder="Confirm Your Password" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400" value="<?php echo $password;?>">
                <label for="confirm_pw" class="block text-red-500 mb-2"><?php echo $confirm_pw_err_msg; ?></label>
            </div>

            <!-- Button -->
            <button type="submit" name="sign_up_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">Submit</button>
        </form>
    </div>
</body>
</html>

