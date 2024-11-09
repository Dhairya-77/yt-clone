<?php
    require_once "db_code.php";

    session_start();

    if(!isset($_SESSION['uid'])){
        header('location:Login.php');
        exit;
    }

    $fullname='';
    $username='';
    $email='';
    $img='';

    $fullname_err_msg = '';
    $email_err_msg = '';
    $username_err_msg='';
    $img_err_msg='';

    if(isset($_POST['save_btn']))
    {
        // check the emply feilds
        if(empty($_POST['full_name']) || empty($_POST['user_name']) || empty($_POST['email']) || empty($_FILES['profile_img']['name']))
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
        }
        else if($con_obj->isUserPresent($_POST['user_name'])){
            $username_err_msg='UserName is aleady exist';
        }
        else if(!preg_match('/^[a-zA-Z0-9.]+@[a-zA-Z.]+\.[a-zA-Z]{2,}$/',$_POST['email'])){
            $email_err_msg='Enter mail in proper format';
        }
        else{

            $db_obj->updateProfiles($_POST['full_name'],$_POST['user_name'],$_POST['email'],);
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
    <title>Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-950 flex items-center justify-center min-h-screen">
    <div class="bg-purple-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <!-- Profile Form -->
        <h2 class="text-yellow-400 font-semibold text-center text-3xl mb-6">Profile</h2>

        <form method="POST">
            <!-- Profile Image Upload -->
            <div class="flex items-center justify-center mb-6">
                <label for="profile_img_upl" class="relative cursor-pointer">
                    <img src="<?php echo $img_path;?>" id="img_preview" name="img_preview" alt="Profile Image" class="w-24 h-24 rounded-full border-4 border-yellow-400 object-cover">
                </label>
                <input type="file" id="profile_img_upl" name="profile_img_upl" accept="image/*" class="hidden">
                <label for="img_preview" class="block text-red-500 mb-2"> <?php echo $img_err_msg; ?> </label>
            </div>

            <!-- Profile Form Fields (same as registration) -->
            <div class="mb-4">
                <label for="full_name" class="block text-yellow-400">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Enter Your Name" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="full_name" class="block text-red-500 mb-2"> <?php echo $fullname_err_msg; ?> </label>
            </div>

            <div class="mb-4">
                <label for="user_name" class="block text-yellow-400">Username</label>
                <input type="text" id="user_name" name="user_name" placeholder="Enter Your Username" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="user_name" class="block text-red-500 mb-2"> <?php echo $username_err_msg; ?> </label>
            </div>

            <div class="mb-6">
                <label for="email" class="block text-yellow-400">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email" class="h-10 w-full mt-2 px-4 py-2 bg-purple-700 text-yellow-400 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <label for="email" class="block text-red-500 mb-2"> <?php echo $email_err_msg; ?> </label>
            </div>

            <!-- Save Changes Button -->
            <button type="submit" name="save_btn" class="w-full bg-yellow-400 text-purple-950 py-2 rounded-md font-semibold hover:bg-yellow-300 transition duration-300">Save Changes</button>
        </form>
    </div>

    <script>
        // JavaScript to preview uploaded profile image
        const profileImageInput = document.getElementById('profile_img_upl');
        const profileImagePreview = document.getElementById('img_preview');

        profileImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileImagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });s
    </script>
</body>
</html>