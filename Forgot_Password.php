<?php
   require_once "db_code.php";
   
    $db_obj=new DB();

    $pw_err_msg='';
    $confirm_pw_err_msg='';
    $username_err_msg='';

    $username='';
    $password='';

    if(isset($_POST['rest_btn'])){

        $username=isset($_POST['username']) ? $_POST['username'] : '';
        $password=isset($_POST['new_pw']) ? $_POST['new_pw'] : '';

        if(empty($_POST['username']) || empty($_POST['new_pw']) || empty($_POST['confirm_pw']))
        {
            if(empty($_POST['username'])){
                $username_err_msg='Enter Username';
            }
            if(empty($_POST['new_pw'])){
                $pw_err_msg='Enter Password';
            }
            if(empty($_POST['confirm_pw'])){
                $confirm_pw_err_msg='Enter Confirm Password';
            }
        }
        else if(!$db_obj->isUserPresent($username)){
            $username_err_msg='Username not exist';
        }
        else if (strlen($password) <= 4) {
            $pw_err_msg = 'Password must be greater than 4 characters'; // password 
        }
        elseif (strcmp($_POST['new_pw'],$_POST['confirm_pw'])!==0) {
            $confirm_pw_err_msg = 'Not Match'; // check password
        }
        else{
            $db_obj->updatePassword($username,$password);
            header('location: Login.php');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind Configuration -->
</head>
<body class="bg-purple-950 min-h-screen flex items-center justify-center">
    <div class="bg-purple-800 rounded-lg shadow-lg p-8 max-w-md w-full">
        <h2 class="text-3xl font-bold text-center text-yellow-400 mb-6">Forgot Password</h2>
        <form method="post">
            <div class="mb-4">
                <label for="username" class="block text-yellow-400 mb-2">Username</label>
                <input type="text" id="username" name="username" value="<?php echo $username;?>" placeholder="Enter Your Username" class="w-full px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="username" name="username_err_text" class="block text-red-500 mb-2"> <?php echo $username_err_msg; ?> </label>
            </div>

            <div class="mb-4">
                <label for="new_pw" class="block text-yellow-400 mb-2">New Password</label>
                <input type="password" id="new_pw" name="new_pw" value="<?php echo $password;?>" placeholder="Enter Your New Password" class="w-full px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="new_pw" name="pw_err_text" class="block text-red-500 mb-2"> <?php echo $pw_err_msg; ?> </label>
            </div>

            <div class="mb-6">
                <label for="confirm_pw" class="block text-yellow-400 mb-2">Confirm New Password</label>
                <input type="password" id="confirm_pw" name="confirm_pw" placeholder="Confirm Your New Password" class="w-full px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="confirm_pw" name="confirm_pw_err_text" class="block text-red-500 mb-2"> <?php echo $confirm_pw_err_msg; ?> </label>
            </div>

            <button type="submit" name="rest_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">Reset Password</button>
        </form>
        <p class="text-yellow-300 mt-6 text-center">Remembered your password? <a href="Login.php" class="text-yellow-400 underline hover:text-yellow-300">Login</a></p>
    </div>
</body>
</html>
